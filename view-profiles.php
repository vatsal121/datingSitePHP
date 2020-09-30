<?php
session_start();
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
require_once("./Connector/DbConnectorPDO.php");
//$connection = getConnection();
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
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>


    <div class="mb15">
        <div class="row mt-10 mb-10">
            <div class="col-md-12 text-center">
                <h2>View Profiles</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top"
                         src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22318%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15c36ed212f%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15c36ed212f%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22118.0859375%22%20y%3D%2297.2%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Name: Test User</h5>
                        <p class="card-text">Likes to build everything.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Age: 25</li>
                        <li class="list-group-item">Location: Montreal</li>
                        <li class="list-group-item">Likes: ABCD, EFGH, IJKL</li>
                        <li class="list-group-item">Interested in: Female</li>
                        <li class="list-group-item">Looking for : Longterm Relation, Short term</li>
                    </ul>
                    <div class="card-body">
                        <?php
                        if ($userId === 0) {
                            ?>
                            <button class="btn btn-success" data-toggle="modal" data-target="#loginModal">
                                Send Message
                            </button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#loginModal">
                                Favourite
                            </button>
                            <?php
                        } else {
                            ?>
                            <a href="#" class="btn btn-success">
                                Send Message
                            </a>
                            <a href="#" class="btn btn-danger">Favourite</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
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
    <!-- footer -->

    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>

</body>
</html>