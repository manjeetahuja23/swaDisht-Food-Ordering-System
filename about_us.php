<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="home">

    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                    data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" height="45px" width="150px"
                        src="images/logo_Swadisht_landscape.png" alt=""> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class=" active navlinkColor" href="index.php">Home <span
                                    class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="active navlinkColor" href="restaurants.php">Menus <span
                                    class="sr-only"></span></a> </li>
                        <li class="nav-item"> <a class="active navlinkColor" href="about_us.php">About Us <span
                                    class="sr-only"></span></a> </li>


                        <?php
                        if (empty($_SESSION["user_id"])) // if user is not login
                        {
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

    <section class="hero bg-image" data-image-src="images/img/about_us.jpg">
        <div class="hero-inner">
            <div class="container text-center hero-text font-white">
                <h1>About Us</h1>
            </div>
        </div>

    </section>





        <div class="container">
            <div class="title text-xs-center m-b-30">
                <h1>Discover Our Story</h1>
                <p class="lead">ULTIMATE DINING EXPERIENCE LIKE NO OTHER</p>
                <p class="lead">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                    laudantium,
                    totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi. Exercitation photo booth
                    stumptown tote bag Banksy, elit small batch freegan sed. Craft beer elit seitan exercitation, photo
                    booth et 8-bit kale chips proident chillwave deep v laborum. Aliquip veniam delectus, Marfa eiusmod
                    Pinterest in do umami readymade.</p>
                <p>
                    <b>OUR FOUNDER - JOHN PHILLIPE</b>
                </p>
            </div>
        </div>
    </section>


    <footer class="footer">
        <div class="container">


            <div class="bottom-footer">
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
    </footer>



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