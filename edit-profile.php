<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
include("./helper/helperFunctions.php");
$connection = getConnection();
$errors = array();
$id = '';
$firstName = '';
$lastName = '';
$email = '';
$bio = '';
$password = '';
$birthDate = '';
$bio = '';
$gender = '';
$image = '';
$birthday = '';
if ($_SESSION['userId']) {
    $userId = $_SESSION['userId'];
    $users = $_SESSION['user'];

    $query = "SELECT * from profile WHERE id = '$userId'";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($count === 0 || $row <= 2) {
        array_push($errors, 'Error fetching Data');
    } else {
        $id = $row['id'];
        $firstName = $row['firstName'];
        $password = $row['password'];
        $lastName = $row['lastName'];
        $email = $row['email'];
        $bio = $row['bio'];
        $birthDate = $row['birthDate'];
        $gender = $row['gender'];
        $image = $row['imgUrl'];

        $birthday = new DateTime($row["birthDate"]);
        $today = new Datetime(date('y-d-m'));
        $diff = $today->diff($birthday);


    }

    if (isset($_POST["uploadImage"]) && isset($_FILES["newImageFileUploadControl"])) {

    }


    if (isset($_POST['Submit'])) {
        $firstName = $_POST['firstName'];
        $password = $_POST['password'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];
        $birthDate = $_POST['birthDate'];
        $gender = $_POST['gender'];

        $query1 = "UPDATE profile SET email = '$email',password = '$password', firstName = '$firstName', lastName = '$lastName', bio = '$bio', birthDate = '$birthDate', gender = '$gender' WHERE id = '$id'";
        $stmt1 = $connection->prepare($query1);
        $stmt1->execute();
        $count1 = $stmt1->rowCount();

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
    <title>Edit Profile</title>
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>


    <div class="container">
        <br>
        <br>
        <div class="row mt-5">
            <?php
            // if any errors are there display them
            if (count($errors) > 0) {
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-danger" role="alert">
                        <?php
                        foreach ($errors as $error) { ?>
                            <li><?= $error ?></li>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="row" id="main">
            <div class="col-md-4 well" id="leftPanel">
                <div class="row">
                    <div class="col-md-12">
                        <img src="<?php echo $image; ?>" height="80%" width="80%" alt="avatar" class="rounded-circle">
                    </div>
                </div>
                <div class="row mb-10">
                    <div class="col-md-12">
                        <form action="edit-profile.php" method="post" enctype="multipart/form-data">
                            <input accept="image/*" name="newImageFileUploadControl" type="file" class=" mb-10">
                            <input type="submit" name="uploadImage" class="form-control btn btn-light"
                                   value="Upload Image"/>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2><?php echo $firstName ?><?php echo $lastName ?> </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3><?php echo "$diff->y years"; ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  disabled><?php echo $bio; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-8 well" id="rightPanel">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-signin" action="edit-profile.php" method="post" enctype="multipart/form-data">
                            <h2>Edit your profile</h2>
                            <hr class="colorgraph">
                            <div class="form-label-group">
                                <input type="text" name="firstName" id="firstName" class="form-control"
                                       placeholder="First Name" value="<?php echo $firstName; ?>">
                                <label for="firstName">First Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" id="lastName" name="lastName" class="form-control"
                                       placeholder="Last Name" value="<?php echo $lastName; ?>">
                                <label for="lastName">Last Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="email" name="email" id="inputEmail" class="form-control"
                                       placeholder="Email address" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$"
                                       value="<?php echo $email; ?>">
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-label-group">
                                <textarea class="form-control" name="bio" id="exampleFormControlTextarea1" rows="3"
                                          placeholder="Bio-info"><?php echo $bio; ?></textarea>
                            </div>
                            <div class="form-label-group">
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       placeholder="Password" value="<?php echo $password; ?>" disabled>
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="form-label-group">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#changePasswordModal">
                                    Change password
                                </button>
                            </div>
                            <div class="form-label-group">
                                <input type="date" id="birthDate" name="birthDate" class="form-control"
                                       value="<?php echo $birthDate; ?>">
                                <label for="birthDate">Birth Date</label>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender"
                                           value="male" <?php if ($gender === "male") {
                                        echo "checked";
                                    } ?>>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender"
                                           value="female" <?php if ($gender === "female") {
                                        echo "checked";
                                    } ?>>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                            <hr class="colorgraph">
                            <div class="row">
                                <div class="col-xs-12 col-md-6"></div>
                                <div class="col-xs-12 col-md-6">
                                    <button class="btn btn-lg btn-primary btn-block text-uppercase" name="Submit"
                                            type="submit">Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalTitle">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        pasword
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Become a premium member</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- footer -->
            <?php include("./includes/footer.php") ?>
            <!-- end of footer -->
        </div>

</body>
</html>