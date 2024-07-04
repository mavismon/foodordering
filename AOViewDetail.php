<?php
if (isset($_GET['purchaseid'])) {
    $purchaseid = $_GET['purchaseid'];

    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "foodorder";
    $conn = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to the database");

    // Fetch the main order details
    $orderSql = "SELECT * FROM purchase WHERE purchaseid = '$purchaseid'";
    $orderQuery = $conn->query($orderSql);
    $orderRow = $orderQuery->fetch_assoc();

    $sql = "SELECT * FROM purchase_detail LEFT JOIN product ON product.productid = purchase_detail.productid WHERE purchaseid = '$purchaseid'";
    $dquery = $conn->query($sql);
    ?>

    <html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to Good Food Restaurant</title>
        <style>
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
                text-align: center; /* Center align the content */
            }

            h2 {
                text-align: center;
                margin-bottom: 30px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th, td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #7D3A2A;
                color: white;
            }

            .image {
                order: 1;
                padding: none;
            }

            /* Top Navigation Styles */
            .topnav {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .topnav a {
                color: #c82a44;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 15px;
                font-family: helvetica;
                margin-top: 20px;
            }

            .topnav a:hover {
                background-color: #CABEC1;
                color: black;
            }

            .topnav .image-link {
                padding: 0;
            }

            .topnav .image-link img {
                max-width: 120px;
                height: auto;
                padding: none;
            }

            .topnav .menu-items {
                float: right;
            }

            .topnav h5 {
                color: #f2f2f2;
                margin: 0;
                padding: 14px 16px;
                font-size: 15px;
            }

            td.photo-column {
                width: 100px;
                height: 100px;
                text-align: center;
            }

            td.photo-column img {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 4px;
            }

            /* Input field style */
            input[type="number"] {
                width: 80px;
            }
            .purchase-id-container {
            margin-bottom: 20px;
            margin-left: 950px;
            font-size:18px;
        }

        .purchase-id-container label {
            font-weight: bold;
        }

     

        </style>
    </head>
    <body>
    <nav>
        <div class="topnav" id="myTopnav">
            <a href="#" title="Logo" class="image-link">
                <img src="image/logo.png" alt="Cafe Logo" class="img-responsive">
            </a>
            <div class="menu-items">
                <a href="APView.php">View Products</a>
                <a href="APAdd.php">Add Product</a>
                <a href="APEdit.php">Edit Product</a>
                <a href="APDelete.php">Delete Product</a>
                <a href="AOView.php" class="active">View Orders</a>
                <a href="ARReview.php">Review</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Order Details</h2>

       <div class="purchase-id-container">
            <label for="purchaseid">Purchase ID:</label>
            <span><?php echo $purchaseid; ?></span>
        </div>
        <table>
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Purchase Quantity</th>
                <th>Subtotal</th>
               
            </tr>
            </thead>
            <tbody>
            <?php
            while ($drow = $dquery->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $drow['productname']; ?></td>
                    <td>$ <?php echo number_format($drow['price'], 2); ?></td>
                    <td>
                        <form action="AOUpdateOrderDetail.php" method="POST">
                            <input type="hidden" name="purchaseid" value="<?php echo $purchaseid; ?>">
                            <input type="hidden" name="productid" value="<?php echo $drow['productid']; ?>">
                            <input type="number" name="quantity" value="<?php echo $drow['quantity']; ?>">
                            <input type="submit" value="Update">
                        </form>
                    </td>
                    <td>$ <?php echo number_format($drow['price'] * $drow['quantity'], 2); ?></td>
                    
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="3" class="total">TOTAL</td>
                <td>$ <?php echo number_format($orderRow['total'], 2); ?></td>
                <td></td>
            </tr>
            </tbody>
        </table>

        <a href="AOView.php" title="Back to Orders" style="color: #c82a44;">Back to Orders</a>

    </div>

    <script>
        function validateQuantity() {
            var quantities = document.querySelectorAll('input[name="quantity"]');
            for (var i = 0; i < quantities.length; i++) {
                var quantity = quantities[i].value;
                if (quantity == 0) {
                    alert('Quantity cannot be zero.');
                    return false;
                }
            }
            return true;
        }
    </script>
    
    </body>
    </html>

    <?php
    mysqli_close($conn);
} else {
    header("Location: AOView.php");
    exit();
}
?>