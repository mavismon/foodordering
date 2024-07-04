<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location: login.php");
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to Good Food Restaurant</title>
        <link rel="stylesheet" type="text/css" href="order.css"/>
        <style>
            /* Your custom CSS styles here */

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

            h1 {
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

            .image{
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
    margin-top:20px;
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
.view-detail {
            color: #c82a44;
            text-decoration: none;
        }

        .view-detail:hover {
            text-decoration: underline;
        }
        .search-form {
        display: flex;
        flex-direction: column;
        max-width: 900px;
        margin: 30px auto;
        align-items: center; /* Added to center the form horizontally */
    }

    .search-form .form-group {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .search-form label {
        margin-top: 2px;
        font-weight: bold;
        text-align: center; /* Added to center the label */
    }

    .search-form .form-group input[type="text"] {
        flex-grow: 1;
        margin-right: 10px;
        font-size: 14px;
        height: 30px;
        max-width: 400px; /* Updated width */
        align:center;  /* Added to center the input text field */
        border: none;
        border-radius: 4px;
    }

    .search-form .form-group .btn-primary {
        padding: 10px;
        font-size: 14px;
        height: 35px;
        width: 100px;
        background-color: #745954; /* Updated color */
        color: white; /* Updated text color */
        border: none;
        cursor: pointer;
        align:center;
    }

    .search-form .form-group .btn-primary:hover {
        background-color: #7D3A2A; /* Updated hover color */
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
        <h2 class="text-center">Order Lists</h2>
        <div class="search-form">
        <form method="get" action="">

            <div class="form-group">
                <label for="search">Purchase ID: </label>
                <input type="text" id="search" name="search" placeholder="   Enter purchase id" size="50px" >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>


   
    <?php
                // PHP code for fetching orders
                $host = "localhost";
                $user = "root";
                $passwd = "";
                $database = "foodorder";
                $conn = mysqli_connect($host, $user, $passwd, $database)
                    or die("Could not connect to the database");

                // Check if search form is submitted
                if (isset($_GET["search"]) && !empty($_GET["search"])) {
                    $search = $_GET["search"];
                    // Modify the query to include the search condition
                    $query = "SELECT date_purchase, purchaseid, customer, remarks, total FROM purchase WHERE purchaseid = '$search' ORDER BY purchaseid DESC";
                } else {
                    $query = "SELECT date_purchase, purchaseid, customer, remarks, total FROM purchase ORDER BY purchaseid DESC";
                }

                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Date</th><th>Purchase ID</th><th>Customer</th><th>Remarks</th><th>Total Sales</th><th>Details</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        $purchaseid = $row['purchaseid'];
                        $date = date('M d, Y h:i A', strtotime($row['date_purchase']));
                        $customer = $row['customer'];
                        $remarks = $row['remarks'];
                        $total = $row['total'];

                        echo "<tr>";
                        echo "<td>".$date."</td>";
                        echo "<td>".$purchaseid."</td>";
                        echo "<td>".$customer."</td>";
                        echo "<td>".$remarks."</td>";
                        echo "<td>$".number_format($total, 2)."</td>";

                        echo "<td><a href='AOViewDetail.php?purchaseid=".$purchaseid."' class='view-detail'>View Details</a></td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No orders found.";
                }

                mysqli_close($conn);
            ?>
        </div>

    <center>
        <p style="font-size: 15px;">
            Click here to <a href="logout.php" title="Logout" style="font-size: 15px; color: red;">Logout</a>
        </p>
    </center>
    </body>
    </html>
    <?php
}
?>




