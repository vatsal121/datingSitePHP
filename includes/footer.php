<?php
include_once("./helper/helperFunctions.php");
$userId = 0;
$user = [];
if (isset($_SESSION["userId"])) {
    $userId = !IsVariableIsSetOrEmpty($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    $user = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION['user']) ? $_SESSION['user'] : [];
}
?>
<footer class="mt-10 bg-dark">
    <div class="container">
        <div class="row ">
            <div class="col-md-4 text-center text-md-left ">

                <div class="py-0">
                    <h3 class="my-4 text-white">ONLINE<span class="mx-2 font-italic text-warning ">DATING</span>
                    </h3>

                    <p class="footer-links font-weight-bold">
                        <a class="text-white" href="./index.php">Home</a>
                        |
                        <a class="text-white" href="./view-profiles.php">View Profiles</a>
                        <?php
                        if ($userId === 0) {
                            ?>
                            |
                            <a class="text-white" href="./login.php">Login</a>
                            |
                            <a class="text-white" href="./register.php">Register</a>
                            <?php
                        } else {
                            ?>
                            |
                            <a class="text-white" href="./edit-profile.php">Edit Profile</a>
                            <?php
                        }
                        ?>

                    </p>
                    <p class="text-light py-4 mb-4">&copy;<?php echo date("Y"); ?> ONLINE DATING</p>
                </div>
            </div>

            <div class="col-md-4 text-white text-center text-md-left ">
                <div class="py-2 my-4">
                    <div>
                        <p class="text-white"><i class="fa fa-map-marker mx-2 "></i>
                            2100 Boulevard de Maisonneuve East,
                            Montréal,
                            Quebec -H2K 4S1</p>
                    </div>

                    <div>
                        <p><i class="fa fa-phone  mx-2 "></i>+1 (514)-123-4567</p>
                    </div>
                    <div>
                        <p><i class="fa fa-envelope  mx-2"></i><a href="mailto:support@onlinedating.com">support@onlinedating.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-white my-4 text-center text-md-left ">
                <span class=" font-weight-bold ">About the Company</span>
                <p class="text-warning my-2">We offer online dating services. A platform to find your perfect life
                    partner.</p>
            </div>
        </div>
    </div>
</footer>