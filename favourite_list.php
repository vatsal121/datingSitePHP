<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
require("./helper/helperFunctions.php");
$userId = isset($_SESSION["userId"]) && !IsVariableIsSetOrEmpty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
$connection = getConnection();
$userObj = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION["user"]) ? $_SESSION["user"] : "";
$firstName = '';
$lastName = '';
$currentTime = '';
$errors = array();
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $users = $_SESSION['user'];
    $queryForSelectProfile = "SELECT * from user_favourite_list ufl INNER JOIN profile pl on ufl.user_id = pl.id WHERE ufl.user_id_favourited = '$userId'";
    $selectStatemenet = $connection->prepare($queryForSelectProfile);
    $selectStatemenet->execute();
    $count = $selectStatemenet->rowCount();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Favourite List</title>
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>
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
    <div class="row mb-10">
        <div class="col-md-12">
           <h2 class="text-center">Favourite List</h2>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped" >
        <thead class="thead-dark">
        <tr>
            <th scope="col">FirstName</th>
            <th scope="col">LastName</th>
            <th scope="col">Favourited On</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while( $row = $selectStatemenet->fetch(PDO::FETCH_ASSOC) ) {
        ?>
        <tr>
            <td><?php echo $row['firstName']; ?></td>
            <td><?php echo $row['lastName']; ?></td>
            <td><?php echo $row['dateCreated']; ?></td>
            <td></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <!-- footer -->
    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>
</body>
</html>
