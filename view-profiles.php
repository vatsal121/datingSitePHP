<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
require("./helper/helperFunctions.php");
$connection = getConnection();
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
//if ($userId !== 0) {
//    $q = "SELECT * from profile WHERE id =:userId";
//    $s = $connection->prepare($q);
//    $s->bindParam(':userId', $userId);
//    $s->execute();
//    $row = $s->fetch(PDO::FETCH_ASSOC);
//
//    $_SESSION['user'] = $row;
//    $userObj = $row;
//}
$userObj = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION["user"]) ? $_SESSION["user"] : "";

$isSearchCriteria = false;
$firstName = "";
$lastName = "";
$gender = "";
$ageToSearch = "18";
$query = "select * from profile ";
if ($userId !== 0) {
    $query .= "where id <> :userId";
}

if (isset($_POST["Search"]) && !IsVariableIsSetOrEmpty($_POST["Search"])) {

    $searchCount = 0;
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $ageToSearch = $_POST["age"];
    $searchQuery = "";

    if (!IsVariableIsSetOrEmpty($firstName)) {
        $searchQuery .= " firstName like '%':fname'%'";
        $searchCount++;
    }
    if (!IsVariableIsSetOrEmpty($lastName)) {
        if ($searchCount > 0) {
            $searchQuery .= " and ";
        }
        $searchQuery .= " lastName like '%':lname'%'";
        $searchCount++;
    }
    if (!IsVariableIsSetOrEmpty($gender)) {
        if ($searchCount > 0) {
            $searchQuery .= " and ";
        }
        $searchQuery .= " gender=:gender";
        $searchCount++;
    }
    if (!IsVariableIsSetOrEmpty($ageToSearch)) {
        $ageToSearch = intval($ageToSearch);
        if ($searchCount > 0) {
            $searchQuery .= " and ";
        }
        if ($ageToSearch === 18) {
            $searchQuery .= " (YEAR(CURDATE()) - YEAR(birthDate)) >=:age";
        } else {
            $searchQuery .= " (YEAR(CURDATE()) - YEAR(birthDate)) BETWEEN  18 and :age";
        }


        $searchCount++;
    }

    if ($searchCount > 0) {
        $isSearchCriteria = true;
        if ($userId === 0) {
            $query .= " where " . $searchQuery;
        } else {
            $query .= " and (" . $searchQuery . ")";
        }
    }
}

$stmt = $connection->prepare($query);
if ($userId !== 0) {
    $stmt->bindParam(':userId', $userId);
}

if ($isSearchCriteria === true) {
    if (!empty($firstName)) {
        $stmt->bindParam(':fname', $firstName);
    }
    if (!empty($lastName)) {
        $stmt->bindParam(':lname', $lastName);
    }
    if (!empty($gender)) {
        $stmt->bindParam(':gender', $gender);
    }
    if (!empty($ageToSearch)) {
        $stmt->bindParam(':age', $ageToSearch);
    }


}
$stmt->execute();
//$profileList = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$profileList = $stmt->fetchAll();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
    <title>View Profiles</title>
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>


    <div class="mb15">
        <div class="row mt-10 mb-10">
            <div class="col-md-12 text-center">
                <h2>Search Profiles</h2>
            </div>
        </div>
        <div class="row mb-10">
            <div class="col-md-12">
                <form method="post" action="view-profiles.php">
                    <div class="form-row mb-10">
                        <div class="col">
                            <div class="form-group">
                                <label for="firsName">Search by first name</label>
                                <input name="firstName" id="firstName" type="text" class="form-control"
                                       placeholder="First name" value="<?= $firstName ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lastName">Search by last name</label>
                                <input name="lastName" id="lastName" type="text" class="form-control"
                                       placeholder="Last name" value="<?= $lastName ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="gender">Search by gender</label>
                                <select id="gender" class="form-control" name="gender">
                                    <option value="" <?php if (empty($gender)) {
                                        echo "selected";
                                    } ?>>-- Select gender
                                        --
                                    </option>
                                    <option value="male" <?php if ($gender === "male") {
                                        echo "selected";
                                    } ?>>Male
                                    </option>
                                    <option value="female" <?php if ($gender === "female") {
                                        echo "selected";
                                    } ?>>Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="formControlRange">Select age range between to search</label>

                                <input type="range" min="18" value="<?= $ageToSearch ?>" max="90"
                                       class="form-control-range" name="age"
                                       id="ageInputId">
                                <output name="ageOutputName" id="ageOutputId">Search profiles with age above 18</output>
                            </div>

                            <!--                            <select class="form-control" name="age">-->
                            <!--                                <option value="">-- Select age --</option>-->
                            <!--                                --><?php
                            //                                for ($i = 18; $i <= 90; $i++) { ?>
                            <!--                                    <option value="--><? //= $i ?><!--">-->
                            <!--                                        --><? //= $i
                            ?><!--</option>-->
                            <!--                                    --><?php
                            //                                }
                            //
                            ?>
                            <!--                            </select>-->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-10 col-sm-12">
                            <input type="submit" name="Search" value="Search" class="btn btn-dark w-100"/>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <input type="submit" name="Reset" value="Reset filters" class="btn btn-info w-100"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (!empty($userObj)) {
            if ($userObj["user_role"] === "regular") {
                ?>
                <div class="row mb-10">
                    <div class="col-md-12">
                        <a href="./become-premium-member.php" class="btn btn-warning w-100 btnPremium"
                           name="BecomePremium">Become a premium member</a>
                    </div>
                </div>
                <?php
            }
        }
        ?>


        <?php
        if (count($profileList) > 0) {
            $counter = 0;
            foreach ($profileList as $profile) {
                $counter++;
                if ($counter === 1) {
                    echo '<div class="row">';
                }
                ?>
                <div class="col-md-3">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top"
                             src="<?= $profile["imgUrl"] ?>"
                             alt="profile image">
                        <div class="card-body">
                            <h5 class="card-title">Name: <?= $profile["firstName"] . ' ' . $profile['lastName'] ?></h5>
                            <p class="card-text"><?= $profile["bio"] ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Age: <?php
                                $bday = new DateTime($profile["birthDate"]); // Your date of birth
                                $today = new Datetime(date('y-d-m'));
                                $diff = $today->diff($bday);
                                echo "$diff->y years"
                                ?></li>
                            <li class="list-group-item">Location: Montreal</li>
                            <li class="list-group-item">
                                Gender:
                                <span style="text-transform: capitalize">
                                    <?= $profile["gender"] ?>
                                </span>
                            </li>
                            <!--                            <li class="list-group-item">Likes: ABCD, EFGH, IJKL</li>-->
                            <!--                            <li class="list-group-item">Interested in: Female</li>-->
                            <!--                            <li class="list-group-item">Looking for : Longterm Relation, Short term</li>-->
                        </ul>
                        <div class="card-body">
                            <?php
                            if ($userId === 0) {
                                ?>
                                <div class="row mb-10">
                                    <div class="col-md-12 col-sm-12">
                                        <button class="btn btn-success w-100" data-toggle="modal"
                                                data-target="#loginModal">
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-info w-100" data-toggle="modal"
                                                data-target="#loginModal">
                                            Send wink
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-danger w-100" data-toggle="modal"
                                                data-target="#loginModal">
                                            Favourite
                                        </button>
                                    </div>
                                </div>

                                <?php
                            } else {
                                ?>
                                <div class="row mb-10">
                                    <div class="col-md-12 col-sm-12">
                                        <button class="btn btn-success w-100">
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-info w-100">
                                            Send wink
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <?php
                                        if ($userObj["user_role"] === "regular") {
                                            ?>
                                            <button class="btn btn-danger w-100" data-toggle="modal"
                                                    data-target="#addToFavouriteModal">
                                                Favourite
                                            </button>

                                            <?php
                                        } else {
                                            ?>
                                            <button class="btn btn-danger w-100">
                                                Favourite
                                            </button>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                if ($counter === 4) {
                    echo '</div>';
                    $counter = 0;
                }
            }
        } else {
            ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info text-center" role="alert">
                        <?php
                        if ($userId !== 0) {
                            ?>
                            No profiles found!.
                            <?php
                        } else {
                            ?>
                            No profiles found!. Click <a href="./register.php">here</a> to register!.
                        <?php } ?>
                    </div>
                </div>

            </div>
            <?php
        }
        ?>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Oops!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You are not logged in. To use this feature please login or create a profile.</p>
                </div>
                <div class="modal-footer">
                    <a href="./login.php" class="btn btn-success">Login</a>
                    <a href="./register.php" class="btn btn-primary">Register</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addToFavouriteModal" tabindex="-1" role="dialog" aria-labelledby="addToFavouriteModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToFavouriteModalTitle">Oops!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Hey! You must be a premium member to add users to your favourite list.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Become a premium member</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#ageInputId").on('input', function () {
                if (parseInt($("#ageInputId").val()) < 18) {
                    $("#ageInputId").val("18");
                }
                if (parseInt($("#ageInputId").val()) === 18) {
                    $("#ageOutputId").val("Search profiles above age " + $("#ageInputId").val());
                } else {
                    $("#ageOutputId").val("Search between age 18 and " + $("#ageInputId").val());
                }
            })
        });
    </script>
    <!-- footer -->

    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>

</body>
</html>