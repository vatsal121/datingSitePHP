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
$userIFavourited = [];
$userThatFavouritedMe = [];
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $users = $_SESSION['user'];
    $queryForSelectProfile = "SELECT ufl.id as favouriteId
                           ,firstName
                           ,lastName
                           ,dateCreated 
                            from user_favourite_list ufl 
                            INNER JOIN profile pl on ufl.user_id = pl.id 
                            WHERE ufl.user_id_favourited = '$userId'";
    $selectStatemenet = $connection->prepare($queryForSelectProfile);
    $selectStatemenet->execute();
    $userThatFavouritedMe = $selectStatemenet->fetchAll();
    $count = $selectStatemenet->rowCount();


    $queryForSelect = "SELECT ufl.id as favouriteId
                       ,firstName
                       ,lastName
                       ,dateCreated 
                       from user_favourite_list ufl 
                       INNER JOIN profile pl on ufl.user_id_favourited = pl.id 
                       WHERE ufl.user_id = '$userId'";
    $SelectUserStatement = $connection->prepare($queryForSelect);
    $SelectUserStatement->execute();
    $userIFavourited = $SelectUserStatement->fetchAll();

    $count1 = $SelectUserStatement->rowCount();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $deleteQuery = "DELETE FROM user_favourite_list WHERE id =$id";
        $deleteUserStatement = $connection->prepare($deleteQuery);
        $deleteUserStatement->execute();
        $count2 = $deleteUserStatement->rowCount();
        if ($count2 === 0) {
            array_push($errors, 'Cant Delete Please try again');
        } else {
            header("Location: ./favourite_list.php");
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
    <title>Favourite List</title>
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>

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
    <table class="table table-bordered table-hover table-striped">
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
        foreach ($userIFavourited as $item) {
            ?>
            <tr>
                <td><?php echo $item['firstName']; ?></td>
                <td><?php echo $item['lastName']; ?></td>
                <td><?php echo $item['dateCreated']; ?></td>
                <td><a href="./favourite_list.php?id=<?php echo $item['favouriteId']; ?>"
                       class="btn btn-danger">Remove</a></td>
            </tr>
        <?php }
        ?>
        <?php
        foreach ($userThatFavouritedMe as $item1) {
            ?>
            <tr>
                <td><?php echo $item1['firstName']; ?></td>
                <td><?php echo $item1['lastName']; ?></td>
                <td><?php echo $item1['dateCreated']; ?></td>
                <td></td>
            </tr>
        <?php }
        if (count($userThatFavouritedMe) <= 0 && count($userIFavourited) <= 0) {
            ?>
            <tr class="text-center">
                <td colspan="4"> No user found in favourite list</td>
            </tr>
        <?php }
        ?>


        </tbody>
    </table>
    <!-- footer -->
    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>
</body>
</html>
