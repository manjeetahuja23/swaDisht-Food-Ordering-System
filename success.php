<?php
include("connection/connect.php");
session_start();
if (empty($_SESSION["user_id"])) {
    header('location:login.php');
} else if (empty($_SESSION["checkout_title"]) && empty($_SESSION["checkout_quantity"]) && empty($_SESSION["checkout_price"])) {
    header('location:your_orders.php');
} else {
    if ($_GET['paymentId']) {
        $SQL = "insert into users_orders(u_id,title,quantity,price,transaction_id) values('" . $_SESSION["user_id"] . "','" . $_SESSION["checkout_title"] . "','" . $_SESSION["checkout_quantity"] . "','" . $_SESSION["checkout_price"] . "', '" . $_GET["paymentId"] . "')";

        mysqli_query($db, $SQL);

        unset($_SESSION["cart_item"]);
        unset($item["title"]);
        unset($item["quantity"]);
        unset($item["price"]);
        $success = "Thankyou! Your Order Placed successfully!";
        echo "<script>window.location.replace('your_orders.php');</script>";

    }
}

?>