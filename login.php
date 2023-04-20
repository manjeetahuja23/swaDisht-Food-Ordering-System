<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch'
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
        #buttn {
            color: #fff;
            background-color: #ff3300;
        }
    </style>


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
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
                        <li class="nav-item"> <a class="active navlinkColor" href="restaurants.php">Menus <span
                                    class="sr-only"></span></a> </li>
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
    <div style=" background-image: url('images/img/background_login.jpg');">

        <?php
        include("connection/connect.php");
        error_reporting(0);
        session_start();
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (!empty($_POST["submit"])) {
                if ($username == "admin") {
                    $loginquery = "SELECT * FROM admin WHERE username='$username' && password='" . md5($password) . "'";
                    $result = mysqli_query($db, $loginquery);
                    $row = mysqli_fetch_array($result);

                    if (is_array($row)) {
                        $_SESSION["adm_id"] = $row['adm_id'];
                        header("refresh:1;url=admin/dashboard.php");
                    } else {
                        echo "<script>alert('Invalid Username or Password!');</script>";
                    }
                } else {
                    $loginquery = "SELECT * FROM users WHERE username='$username' && password='" . md5($password) . "'"; //selecting matching records
                    $result = mysqli_query($db, $loginquery); //executing
                    $row = mysqli_fetch_array($result);

                    if (is_array($row)) {
                        $_SESSION["user_id"] = $row['u_id'];
                        header("refresh:1;url=index.php");
                    } else {
                        $message = "Invalid Username or Password!";
                    }
                }
            }


        }
        ?>

        <br />
        <br />
        <div class="pen-title">
        </div>

        <div class="module form-module">
            <div class="toggle">

            </div>
            <div class="form">
                <h2>Login to your account</h2>
                <span style="color:red;">
                    <?php echo $message; ?>
                </span>
                <span style="color:green;">
                    <?php echo $success; ?>
                </span>
                <form action="" method="post">
                    <input type="text" placeholder="Username" name="username" />
                    <input type="password" placeholder="Password" name="password" />
                    <input type="submit" id="buttn" name="submit" value="Login" />
                </form>
            </div>

            <div class="cta">Not registered?<a href="registration.php" style="color:#f30;"> Create an
                    account</a></div>
        </div>
        <br />
        <br />

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>




        <div class="container-fluid pt-3">
            <p></p>
        </div>



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



</body>

</html>