<?php
include_once("./helper/helperFunctions.php");
$userId = 0;
$user = [];
if (isset($_SESSION["userId"])) {
    $userId = !IsVariableIsSetOrEmpty($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    $user = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION['user']) ? $_SESSION['user'] : [];
}
?>
<header>
    <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
        <a class="navbar-brand" href="./index.php">
            <!--        <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/logo_white.png" width="30" height="30" alt="logo">-->
            ONLINE <span class="text-warning ">DATING</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-2"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbar-list-2">
            <ul class="navbar-nav">
                <?php
                if ($userId !== 0 && count($user) > 0) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                           onclick="return false">Hello <?= $user["firstName"] . " " . $user["lastName"] ?>!</a>
                    </li>
                    <?php
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./view-profiles.php">View Profiles</a>
                </li>
                <?php
                if ($userId !== 0) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./edit-profile.php">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="./register.php">Register</a>
                    </li>
                    <?php
                }
                ?>

            </ul>

        </div>
    </nav>
</header>