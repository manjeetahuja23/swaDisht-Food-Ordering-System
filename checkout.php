<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';

error_reporting(0);
session_start();


function function_alert()
{
    echo "<script>window.location.replace('your_orders.php');</script>";
}

if (empty($_SESSION["user_id"])) {
    header('location:login.php');
} else {


    foreach ($_SESSION["cart_item"] as $item) {

        $item_total += ($item["price"] * $item["quantity"]);

        if ($_POST['submit']) {

            if ($_POST['mod'] == 'paypal') {

                $_SESSION["checkout_title"] = $item["title"];
                $_SESSION["checkout_quantity"] = $item["quantity"];
                $_SESSION["checkout_price"] = $item["price"];

                $api_endpoint = 'https://api.sandbox.paypal.com/v1/';
                $client_id = 'AZg69KWaG17wHf2gW-gFheTT_02M6XPTuFlB-ynNfn2LcvM6FIwV3SnqUXY4_vcC64kXLvChuCtJgWtX';
                $client_secret = 'EAHuzeJzZDT56YMdWgyxWGLxAiXGGaq8rCWjb0RIh7oN3a6m1dcAFEOOXzD1Okydmwv0jjhP26EUTF6R';

                // Set up the cURL request to obtain an access token
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_endpoint . 'oauth2/token');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $client_secret);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
                $response = curl_exec($ch);
                $access_token = json_decode($response)->access_token;

                // Set up the cURL request to create a payment
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_endpoint . 'payments/payment');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $access_token
                    )
                );
                curl_setopt($ch, CURLOPT_POSTFIELDS, '{
                    "intent": "sale",
                    "payer": {
                        "payment_method": "paypal"
                    },
                    "transactions": [{
                        "amount": {
                        "total": "' . $item["price"] . '",
                        "currency": "CAD"
                        }
                    }],
                    "redirect_urls": {
                        "return_url": "http://group5.shopanythingpro.com/swadisht/success.php",
                        "cancel_url": "http://group5.shopanythingpro.com/swadisht/cancel.php"
                    }
                    }');
                $response = curl_exec($ch);
                $payment_id = json_decode($response)->id;
                $approval_url = json_decode($response)->links[1]->href;

                // Redirect the user to the PayPal Sandbox for approval
                header('Location: ' . $approval_url);
            } else {
                $SQL = "insert into users_orders(u_id,title,quantity,price,transaction_id) values('" . $_SESSION["user_id"] . "','" . $item["title"] . "','" . $item["quantity"] . "','" . $item["price"] . "','COD')";

                mysqli_query($db, $SQL);

                unset($_SESSION["cart_item"]);
                unset($item["title"]);
                unset($item["quantity"]);
                unset($item["price"]);
                $success = "Thankyou! Your Order Placed successfully!";

                function_alert();
            }


        }
    }
    ?>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>Checkout</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <div class="site-wrapper">
            <header id="header" class="header-scroll top-header headrom">
                <nav class="navbar navbar-dark">
                    <div class="container">
                        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                            data-target="#mainNavbarCollapse">&#9776;</button>
                        <a class="navbar-brand" href="index.php"> <img class="img-rounded" height="45px" width="150px"
                                src="images/logo_Swadisht_landscape.png" alt=""> </a>
                        <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                            <ul class="nav navbar-nav">
                                <li class="nav-item"> <a class="active navlinkColor" href="index.php">Home <span
                                            class="sr-only">(current)</span></a> </li>
                                <li class="nav-item"> <a class="active navlinkColor" href="restaurants.php">Menus
                                        <span class="sr-only"></span></a> </li>
                                <li class="nav-item"> <a class="active navlinkColor" href="about_us.php">About Us <span
                                            class="sr-only"></span></a> </li>
                                <?php
                                if (empty($_SESSION["user_id"])) {
                                    echo '<li class="nav-item"><a href="login.php" class="active navlinkColor">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="active navlinkColor">Signup</a> </li>';
                                } else {


                                    echo '<li class="nav-item"><a href="your_orders.php" class="active navlinkColor">Your Orders</a> </li>';
                                    echo '<li class="nav-item"><a href="logout.php" class="active navlinkColor">Logout</a> </li>';
                                }

                                ?>

                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="page-wrapper">
                <div class="top-links">
                    <div class="container">
                        <ul class="row links">

                            <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose
                                    Menu</a></li>
                            <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite food</a>
                            </li>
                            <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and
                                    Pay</a></li>
                        </ul>
                    </div>
                </div>

                <div class="container">

                    <span style="color:green;">
                        <?php echo $success; ?>
                    </span>

                </div>




                <div class="container m-t-30">
                    <form action="" method="post">
                        <div class="widget clearfix">

                            <div class="widget-body">
                                <form method="post" action="#">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="cart-totals margin-b-20">
                                                <div class="cart-totals-title">
                                                    <h4>Cart Summary</h4>
                                                </div>
                                                <div class="cart-totals-fields">

                                                    <table class="table">
                                                        <tbody>



                                                            <tr>
                                                                <td>Cart Subtotal</td>
                                                                <td>
                                                                    <?php echo "$" . $item_total; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Delivery Charges</td>
                                                                <td>Free</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-color"><strong>Total</strong></td>
                                                                <td class="text-color"><strong>
                                                                        <?php echo "$" . $item_total; ?>
                                                                    </strong></td>
                                                            </tr>
                                                        </tbody>




                                                    </table>
                                                </div>
                                            </div>
                                            <div class="payment-option">
                                                <ul class=" list-unstyled">
                                                    <li>
                                                        <label class="custom-control custom-radio  m-b-20">
                                                            <input name="mod" id="radioStacked1" checked value="COD"
                                                                type="radio" class="custom-control-input"> <span
                                                                class="custom-control-indicator"></span> <span
                                                                class="custom-control-description">Cash on Delivery</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio  m-b-10">
                                                            <input name="mod" id="radioStacked1" type="radio" value="paypal"
                                                                class="custom-control-input"> <span
                                                                class="custom-control-indicator"></span> <span
                                                                class="custom-control-description">Paypal <img
                                                                    src="images/paypal.jpg" alt="" width="90"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <p class="text-xs-center"> <input type="submit"
                                                        onclick="return confirm('Do you want to confirm the order?');"
                                                        name="submit" class="btn btn-outline-success btn-block"
                                                        value="Order now"> </p>
                                            </div>
                                </form>
                            </div>
                        </div>

                </div>
            </div>
            </form>
            <br />
        </div>

        <footer class="footer">
            <div class="row bottom-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 payment-options color-gray">
                            <h5>Payment Options</h5>
                            <ul>
                                <li>
                                    <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/stripe.png" alt="Stripe"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/bitcoin.png" alt="Bitcoin"> </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4 address color-gray">
                            <h5>Address</h5>
                            <p>123, Keele Street, North York, Toronto, <br />Ontario - M3J 3V4</p>
                            <h5>Phone: +1 4373424562</a></h5>
                            <h5>Email: info@swadisht.com</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </footer>
        </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/animsition.min.js"></script>
        <script src="js/bootstrap-slider.min.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/headroom.js"></script>
        <script src="js/foodpicky.min.js"></script>
    </body>

    </html>

    <?php
}
?>