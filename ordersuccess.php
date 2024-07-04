<?php
session_start();
if (isset($_SESSION["sess_pid"]) && isset($_SESSION["total"])) {
    $purchaseId = $_SESSION["sess_pid"];
    $total = $_SESSION["total"];

    // Check if the cancellation request is within 10 seconds
    $currentTime = time();
    $orderTime = isset($_SESSION["order_time"]) ? $_SESSION["order_time"] : $currentTime;
    $elapsedTime = $currentTime - $orderTime;

    if ($elapsedTime <= 10) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>Welcome to Good Food Restaurant</title>
            <link rel="stylesheet" type="text/css" href="Order.css"/>
            <style>
                .error {color: #FF0001;}
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #CABEC1;
                }

                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    border-radius: 5px;
                    padding: 20px;
                    background-color: #CABEC1;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
                }

                h2 {
                    text-align: center;
                    margin-bottom: 30px;
                }

                p {
                    text-align: center;
                    margin-bottom: 20px;
                }

                h3 {
                    text-align: center;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
        <nav>
         <div class="topnav" id="myTopnav">
           <div class="logo">
             <a href="#" title="Logo" class="image-link">
               <img src="image/logo.png" alt="Cafe Logo" class="img-responsive">
             </a>
           </div>

            <div class="menu-items">
                <?php if ($elapsedTime <= 10) { ?>
                    <a href="ordercancel.php">Cancel Order</a>
                <?php } ?>
                <a href="home.html">Home</a>
             <a href="About.html">About</a>
             <a href="UPView.php">Food</a>
             <a href="Order.php">Order</a>
             <a href="UReview.php">Review</a>
            </div>
            </div>
        </nav>

        <div class="container">
            <h2>Order Success</h2>
            <p>Your order has been placed successfully!</p>
            <h3>Order Details:</h3>
            <p>Order ID: <?php echo $purchaseId; ?></p>
            <p>Total Price: <?php echo $total; ?></p>
        </div>
        </body>
        </html>
        <?php
    } else {
        // Redirect to the order.php page if the cancellation window has expired
        header("Location: order.php");
        exit();
    }
} else {
    // Redirect to the order.php page if the order ID or total is not set
    header("Location: order.php");
    exit();
}
?>
