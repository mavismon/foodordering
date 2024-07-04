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
        if (isset($_POST["cancel"])) {
            // Cancel the order
            // Add your cancellation logic here

            // Remove the order from the database
            $pdo = new PDO("mysql:host=localhost;dbname=foodorder", "root", "");
            $stmt1 = $pdo->prepare("DELETE FROM purchase_detail WHERE purchaseid = :purchaseId");
            $stmt1->bindParam(":purchaseId", $purchaseId);
            $stmt1->execute();

            $stmt2 = $pdo->prepare("DELETE FROM purchase WHERE purchaseid = :purchaseId");
            $stmt2->bindParam(":purchaseId", $purchaseId);
            $stmt2->execute();

            // Display a success message after canceling the order
            echo '<script>alert("Your order with ID: ' . $purchaseId . ' has been successfully canceled."); </script>';
            // Delay the redirection to order.php for displaying the success message
            echo '<script>window.location.href = "order.php";</script>';
          //  header("Refresh: 1; url=order.php");
            exit();
        }
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
                    max-width: 400px;
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
                .error {
                color: #7D3A2A;
                font-size: 16px;
                text-align: center;
                margin-bottom: 10px;
                font-weight: bold;
            }
            .button{
                background-color: #745954;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-right: 10px;|
                size:30px;
                align:center;

            }
            .button:hover{
                background-color: #7D3A2A;
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
            <h2>Order Cancellation</h2>
            <?php if ($elapsedTime <= 10) { ?>
                <p>Are you sure you want to cancel the order with ID: <?php echo $purchaseId; ?>?</p>
                <form action="" method="post">
                    <input type="hidden" name="purchaseId" value="<?php echo $purchaseId; ?>">
                    <div style="text-align: center;">
    <input type="submit" name="cancel" value="Cancel Order" class="button">
</div>
  
                </form>
            <?php } else { ?>
                <p>Sorry, the cancellation window has expired. You can only cancel the order within 10 seconds.</p>
            <?php } ?>
        </div>

        </body>
        </html>

        <?php
    } else {
        // Redirect to the order.php page if the cancellation window has expired
        header("Location: order.php");
        exit();
    }
}
?>
