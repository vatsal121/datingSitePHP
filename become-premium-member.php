<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
require("./helper/helperFunctions.php");
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
$userObj = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION["user"]) ? $_SESSION["user"] : "";
$connection = getConnection();
if (isset($_POST["checkout"]) && !IsVariableIsSetOrEmpty($_POST["checkout"])) {
    $query = "update profile set user_role='premium' where id=:userId";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $userObj["user_role"] = "premium";
    $_SESSION["user"] = $userObj;

    header("location:./view-profiles.php");
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
    <link href="./css/style.css" rel="stylesheet" type="text/css">
    <title>Become Premium Member</title>
</head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>
    <div class="container">
        <div class="row mt-10 mb-10 justify-content-center">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                </h4>
                <ul class="list-group mb-3">


                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Membership fee</h6>
                            <small class="text-muted">Become a premium member by paying </small>
                        </div>
                        <span class="text-muted">$15/month</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Special Discount</h6>
                            <small>DATINGFOREVER</small>
                        </div>
                        <span class="text-success">-$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$15</strong>
                    </li>
                </ul>


            </div>
            <div class="col-md-8 col-md-offset-2 order-md-1">

                <form class="needs-validation" method="post" action="become-premium-member.php" novalidate="">

                    <h4 class="mb-3">Payment</h4>

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked=""
                                   required="">
                            <label class="custom-control-label" for="credit">Credit card</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input"
                                   required="">
                            <label class="custom-control-label" for="debit">Debit card</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Name on card</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback">
                                Name on card is required
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">Credit card number</label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                            <div class="invalid-feedback">
                                Credit card number is required
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">Expiration</label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                            <div class="invalid-feedback">
                                Expiration date required
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                            <div class="invalid-feedback">
                                Security code required
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <input class="btn btn-primary btn-lg btn-block" name="checkout" type="submit"
                           value="Continue to checkout">
                </form>
            </div>
        </div>

    </div>


    <!-- footer -->

    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';

        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');

            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>
</html>
