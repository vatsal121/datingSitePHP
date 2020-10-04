<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
include("./helper/helperFunctions.php");
$connection = getConnection();
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
if ($userId !== 0) {
    header("Location: ./index.php");
}

$errors = array();
$image_uploaded = false;
$imageURL = "./images/user_images/";
$registerSuccessfully = false;
if (isset($_POST['Submit'])) {
    $email = $_POST['email'];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["password"];
    $confirmpassword = $_POST['confirmpassword'];
    $city = $_POST['city'];
    $dateOfBirth = $_POST["birthDate"];
    $gender = $_POST["gender"];

    if($password === $confirmpassword) {

        if (!IsVariableIsSetOrEmpty($email) && !IsVariableIsSetOrEmpty($firstName) && !IsVariableIsSetOrEmpty($lastName) && !IsVariableIsSetOrEmpty($password) && !IsVariableIsSetOrEmpty($dateOfBirth) && !IsVariableIsSetOrEmpty($gender)) {
            if (!IsVariableIsSetOrEmpty($_FILES['fileUpload'])) {
                $file_name = $email . "_" . $_FILES['fileUpload']['name'];
                $file_size = $_FILES['fileUpload']['size'];
                $file_tmp = $_FILES['fileUpload']['tmp_name'];
                $file_type = $_FILES['fileUpload']['type'];
                $array = explode('.', $_FILES['fileUpload']['name']);
                $file_ext = strtolower(end($array));

                $extensions = array("jpeg", "jpg", "png", "gif");

                if ($file_size > 5120000) {
                    array_push($errors, 'File size must be less than 5 MB');
                }

                if (empty($errors) == true) {

                    $imageURL = $imageURL . $file_name;
                    move_uploaded_file($file_tmp, $imageURL);
                    $image_uploaded = true;
                    try {
                        $query = "INSERT INTO datingdb.profile(email,password,firstName,lastName,city,birthDate,gender,imgUrl,user_role) values('$email','$password','$firstName','$lastName','$city','$dateOfBirth','$gender','$imageURL','regular')";
                        $stmt = $connection->prepare($query);
                        $stmt->execute();
                        $registerSuccessfully = true;
                    } catch (PDOException $exception) {
                        throw $exception;
                    }

                }
            }
        }
    }else{
        array_push($errors, 'Password and Confirm Password doesnt match');
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
    <title>View Profiles</title>
    <?php include("./includes/header.php") ?>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php
                        // if any errors are there display them
                        if (count($errors) > 0) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <p>List of errors: </p>
                                <ul>
                                    <?php
                                    foreach ($errors as $error) { ?>
                                        <li><?= $error ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } elseif ($registerSuccessfully === true) {
                            ?>
                            <div class="alert alert-success" role="alert">
                                <p>Registered Successfully. Click <a href="./login.php">here</a> to login.</p>
                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <div class="card card-signin flex-row ">

                    <div class="card-img-left d-none d-md-flex">
                        <!-- Background image for card set in CSS! -->
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Register</h5>
                        <form class="form-signin" action="register.php" method="post" enctype="multipart/form-data">
                            <div class="form-label-group">
                                <input type="email" name="email" id="inputEmail" class="form-control"
                                       placeholder="Email address" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$"
                                       required autofocus>
                                <label for="inputEmail">Email address</label>
                            </div>

                            <div class="form-label-group">
                                <input type="text" name="firstName" id="firstName" class="form-control"
                                       placeholder="First Name" required>
                                <label for="firstName">First Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" id="lastName" name="lastName" class="form-control"
                                       placeholder="Last Name" required>
                                <label for="lastName">Last Name</label>
                            </div>
                            <hr>

                            <div class="form-label-group">
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" name="confirmpassword" id="inputConfirmPassword" class="form-control"
                                       placeholder="Password" required>
                                <label for="inputConfirmPassword">Confirm password</label>
                            </div>
                            <hr>
                            <div class="form-label-group">
                                <input type="text" name="city" id="inputCity" class="form-control"
                                       placeholder="City" required>
                                <label for="inputCity">City</label>
                            </div>
                            <div class="form-label-group">
                                <input type="date" id="birthDate" name="birthDate" class="form-control" required>
                                <label for="birthDate">Birth Date</label>
                            </div>

                            <div class="form-group">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender"
                                           value="male" checked required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender"
                                           value="female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                            <hr>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input accept="image/*" type="file" name="fileUpload"
                                           class="form-control custom-file-input"
                                           id="fileUpload" required>
                                    <label class="custom-file-label" for="fileUpload">Upload Image..</label>
                                </div>
                            </div>

                            <div class="preview-img-container form-group" style="display: none">
                                <img id="img_preview" class="rounded mx-auto d-block" src="#"
                                     alt="your image" width="100"
                                     height="100"/>
                                <button type="button" class="btn btn-success preview-btn" onclick="removePreview()">
                                    X
                                </button>
                            </div>
                            <button name="Submit" id="Submit"
                                    class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">
                                Register
                            </button>
                            <div class="sign-up">
                                Have an account? <a href="./login.php">Login</a>
                            </div>
                        </form>
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

    function removePreview() {
        $('#img_preview').attr('src', "");
        $(".preview-img-container").css("display", "none");
        $('#fileUpload').val('');
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
                $(".preview-img-container").css("display", "block");
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string

        }
    }

    $("#fileUpload").change(function () {
        readURL(this);
    });
</script>
</body>
</html>