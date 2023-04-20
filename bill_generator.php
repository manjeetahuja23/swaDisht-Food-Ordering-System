<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;

include("connection/connect.php");

if ($_GET['o_id']) {

    $query_res = mysqli_query($db, "select * from users_orders where o_id='" . $_GET['o_id'] . "'");
    if (!mysqli_num_rows($query_res) > 0) {
        header('location:your_orders.php');
    } else {

        while ($row = mysqli_fetch_array($query_res)) {
            $transaction_id = $row['transaction_id'];
            if ($transaction_id == "COD") {
                $transaction_id = "CASH ON PICK-UP";
            } else {
                $transaction_id = "Transaction ID: " . $transaction_id;
            }
            $dompdf = new Dompdf();

            // set the HTML content to be rendered
            $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Bill</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    line-height: 1.5;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ccc;
                }
                th {
                    background-color: #f0f0f0;
                    text-align: left;
                }
                .total {
                    text-align: right;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <center><h1>Swadisht</h1>
            <p>Where Swad meets swag... </p></center>
            <h3>Invoice number: ' . $row['o_id'] . '</h3>
            <h3>Invoice date: ' . $row['date'] . '</h3>
            <table>
                <thead>
                    <tr>
                        <th>Dish</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . $row['title'] . '</td>
                        <td>' . $row['quantity'] . '</td>
                        <td>$' . $row['price'] . '</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="total">Total (including 13% Tax):</td>
                        <td>$' . ($row['price'] + (($row['price'] * 13) / 100)) . '</td>
                    </tr>
                </tbody>
            </table>
            <h3>' . $transaction_id . '</h3>
            <p>Thank you for being our valued customer !</p>
        </body>
        </html>
        ';
            $dompdf->loadHtml($html);

            // render the HTML as PDF
            $dompdf->render();

            // output the PDF file to the browser
            $dompdf->stream('swadisht - where swad meets swag !!.pdf');
            break;
        }
    }
} else {
    header('location:your_orders.php');
}
?>