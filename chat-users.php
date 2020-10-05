<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
require("./helper/helperFunctions.php");
$userId = isset($_SESSION["userId"]) && !IsVariableIsSetOrEmpty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
$connection = getConnection();
$userObj = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION["user"]) ? $_SESSION["user"] : "";
$msgList = [];
$recentMsgList = [];
$msgToUserId = isset($_GET["id"]) && !IsVariableIsSetOrEmpty($_GET["id"]) ? $_GET["id"] : 0;

if (isset($_POST["SendMessage"]) && !IsVariableIsSetOrEmpty($_POST["SendMessage"])) {
    $msg = $_POST["msg"];
    if (isset($msg) && !IsVariableIsSetOrEmpty($msg)) {
        $insertMessageQuery = "INSERT INTO messages(msg_from_user_id,msg,msg_to_user_id,msg_date,is_msg_read) 
                               values(:userId,:msg,:msgToUserId,NOW(),0)";
        $insertStmt = $connection->prepare($insertMessageQuery);
        $insertStmt->bindParam(':userId', $userId);
        $insertStmt->bindParam(':msg', $msg);
        $insertStmt->bindParam(':msgToUserId', $msgToUserId);
        $insertStmt->execute();
    }

}

if ($userId === 0 || (!isset($_GET["id"]) && !isset($msgToUserId))) {
    header("location:./view-profiles.php");
}

if ($msgToUserId !== 0) {

    $recentMsgQuery = "select *
from (
SELECT PROFILE
    .id,
    PROFILE.firstName,
    PROFILE.lastName,
    PROFILE.imgUrl,
    (
    SELECT
        msg
    FROM
        messages
    WHERE
        messages.msg_from_user_id = PROFILE.id OR messages.msg_to_user_id = PROFILE.id
    ORDER BY
        id
    DESC
LIMIT 1
) AS lastMessage,(
    SELECT
        msg_date
    FROM
        messages
    WHERE
        messages.msg_from_user_id = PROFILE.id OR messages.msg_to_user_id = PROFILE.id
    ORDER BY
        id
    DESC
LIMIT 1
) AS msgDate
FROM PROFILE
where id <> :userId 
) X
WHERE lastMessage is not null";
    $recentQueryStmt = $connection->prepare($recentMsgQuery);
    $recentQueryStmt->bindParam(':userId', $userId);
    $recentQueryStmt->execute();
    $recentMsgList = $recentQueryStmt->fetchAll();


    $query = "SELECT m.id as msg_id
	  ,msg_from_user_id
      ,msg_to_user_id
      ,msg
      ,msg_date
      ,is_msg_read
      ,msg_read_date
      ,fromUser.id as fromUserId
      ,fromUser.firstName as fromFirstName
      ,fromUser.lastName as fromLastName
      ,fromUser.imgUrl as fromUserImgUrl
      ,toUser.id as toUserId
      ,toUser.firstName as toUserFirstName
      ,toUser.lastName as toUserLastName
      ,toUser.imgUrl as toUserImgUrl
FROM messages m
left join profile as fromUser on m.msg_from_user_id=fromUser.id
left JOIN profile as toUser on m.msg_to_user_id=toUser.id
WHERE (msg_from_user_id =:userId and msg_to_user_id=:sentToUserID) or (msg_from_user_id=:sentToUserID and msg_to_user_id=:userId)";
//ORDER BY msg_date DESC";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':sentToUserID', $_GET["id"]);
    $stmt->execute();
    $msgList = $stmt->fetchAll();

    if (count($msgList) > 0) {
        $lastMsgRow = end($msgList);
        if ($lastMsgRow["msg_from_user_id"] === $msgToUserId && $lastMsgRow["msg_to_user_id"] === $userId && intval($lastMsgRow["is_msg_read"]) === 0) {
            $updateAllMsgReadQuery = "UPDATE messages set is_msg_read=1,msg_read_date=NOW() where msg_from_user_id=:sentToUserID and msg_to_user_id=:userId and is_msg_read=0";
            $stmt = $connection->prepare($updateAllMsgReadQuery);
            $stmt->bindParam(':sentToUserID', $msgToUserId);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("./includes/header.php") ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet"

    <link href="./css/style.css" rel="stylesheet" type="text/css">

    <title>Chat</title>
    <style>
        .container {
            max-width: 1170px;
            margin: auto;
        }

        img {
            max-width: 100%;
        }

        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%;
            border-right: 1px solid #c4c4c4;
        }

        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }


        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
            padding:
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_img img {
            height: 45px;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
            cursor: pointer;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #ebebeb;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 60%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg, .incoming_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .outgoing_msg_img {
            display: inline-block;
            width: 6%;
            float: right;
        }

        .outgoing_msg_img img, .incoming_msg_img img {
            height: 35px;
        }

        .sent_msg {
            float: right;
            width: 46%;
            padding: 0 10px 0 0px;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>


    <div class="row mb-10">
        <div class="container">
            <h3 class="mt-10 text-center">Messaging</h3>
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent Chats</h4>
                            </div>
                            <!--                            <div class="srch_bar">-->
                            <!--                                <div class="stylish-input-group">-->
                            <!--                                    <input type="text" class="search-bar" placeholder="Search">-->
                            <!--                                    <span class="input-group-addon">-->
                            <!--                                            <button type="button">-->
                            <!--                                                <i class="fa fa-search" aria-hidden="true"></i>-->
                            <!--                                            </button>-->
                            <!--                                     </span>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <div class="inbox_chat">
                            <?php
                            if (count($recentMsgList) > 0) {
                                foreach ($recentMsgList as $recentMsgItem) {
                                    ?>
                                    <div class="chat_list <?= $recentMsgItem["id"] === $msgToUserId ? "active_chat" : "" ?>"
                                         data-id="<?= $recentMsgItem["id"] ?>">
                                        <div class="chat_people">
                                            <div class="chat_img">
                                                <img class="rounded-circle" src="<?= $recentMsgItem["imgUrl"] ?>"
                                                     alt="to-user-img">
                                            </div>
                                            <div class="chat_ib">
                                                <h5>
                                                    <!--                                                <a href="./chat-users.php?id=-->
                                                    <?//= $recentMsgItem["id"] ?><!--">-->
                                                    <?= $recentMsgItem["firstName"] . ' ' . $recentMsgItem["lastName"] ?>
                                                    <!--                                                </a>-->
                                                    <span class="chat_date">
                                                    <?= $recentMsgItem["msgDate"] ?>
                                                </span>
                                                </h5>
                                                <p><?= $recentMsgItem["lastMessage"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="row mb-10" style="margin-top:10px ">
                                    <div class="col-md-12">
                                        <div class="alert alert-primary text-center" role="alert">
                                            No chats found! Start chatting by clicking <strong><a
                                                        href="./view-profiles.php" class="alert-link">"Send Message
                                                    button"</a></strong> on profiles page!.
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mesgs">
                        <div class="msg_history">
                            <?php
                            foreach ($msgList

                                     as $item) {
                                if ($item["fromUserId"] === $userId) {
                                    ?>
                                    <div class="outgoing_msg">
                                        <div class="outgoing_msg_img">
                                            <img class="rounded-circle" src="<?= $item["fromUserImgUrl"] ?>"
                                                 alt="img">
                                        </div>
                                        <div class="sent_msg">
                                            <p><?= $item["msg"] ?></p>
                                            <span class="time_date">
                                                <?= $item["msg_date"] ?>
                                            </span>
                                            <span class="time_date">
                                                 <?php
                                                 if ($userObj["user_role"] === "premium") {
                                                     if (intval($item["is_msg_read"]) === 0) {
                                                         ?>
                                                         Delivered and Not read
                                                     <?php } else {
                                                         ?>Read by <?= $item["toUserFirstName"] . '' . $item["toUserLastName"] ?> at <?= $item["msg_read_date"] ?>
                                                     <?php }
                                                 }
                                                 ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="incoming_msg">
                                        <div class="incoming_msg_img">
                                            <img class="rounded-circle" src="<?= $item["fromUserImgUrl"] ?>"
                                                 alt="img">
                                        </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p><?= $item["msg"] ?></p>
                                                <span class="time_date"><?= $item["msg_date"] ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <form action="chat-users.php?id=<?= $msgToUserId ?>" method="post">
                                    <input type="text" name="msg" class="write_msg" placeholder="Type a message"
                                           required/>
                                    <button id="sendBtn" class="msg_send_btn" type="button">
                                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                    </button>
                                    <input type="submit" id="sendMessage" style="display: none;" value="Send"
                                           name="SendMessage"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- footer -->
    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>
<script>
    $(document).ready(function () {

        <?php
        if (count($recentMsgList) > 0) {
        ?>
        $(".chat_list").on('click', function () {
            let id = $(this).attr("data-id");
            if (id) {
                window.location.href = "./chat-users.php?id=" + id;
            }
        });
        <?php }
        ?>
        $("#sendBtn").on('click', function () {
            $("#sendMessage").click();
        });
    });
</script>
</body>
</html>