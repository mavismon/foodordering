<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="Order.css"/>
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
            background-color:#CABEC1;
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
                <a href="AOView.php">View Orders</a>
                <a href="ARReview.php" class="active">Review</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center">Customer Comments</h2>

        <div class="search-form">
        <form method="get" action="">

            <div class="form-group">
                <label for="search">Product Name: </label>
                <input type="text" id="search" name="search" placeholder="  Enter product name" size="50px" >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

<?php
        // PHP code for fetching reviews
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "foodorder";
        $table_name = "review";
        $connect = mysqli_connect($host, $user, $passwd, $database)
            or die("Could not connect to the database");

        // Check if the delete button is clicked
        if (isset($_GET['delete'])) {
            $reviewId = $_GET['delete'];

            // Create the delete query
            $deleteQuery = "DELETE FROM $table_name WHERE rid = $reviewId";

            // Execute the delete query
            mysqli_query($connect, $deleteQuery);
        }

        // Check if the search form is submitted
        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];

            // Create the search query
            $searchQuery = "SELECT * FROM $table_name WHERE productname LIKE '%$searchTerm%'";

            // Execute the search query
            $result = mysqli_query($connect, $searchQuery);
        } else {
            // No search term provided, fetch all reviews
            $query = "SELECT * FROM $table_name";
            mysqli_select_db($connect, $database);
            $result = mysqli_query($connect, $query);
        }

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Customer Name</th><th>Email</th><th>Product Name</th><th>Comments</th><th>Date</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                // Fetch the review details
                $rid = $row['rid'];
                $customer = $row['customer'];
                $cemail = $row['email'];
                $pname = $row['productname'];
                $comment = $row['comment'];
                $cdate = $row['Date'];

                echo "<tr>";
                echo "<td>".$rid."</td>";
                echo "<td>".$customer."</td>";
                echo "<td>".$cemail."</td>";
                echo "<td>".$pname."</td>";
                echo "<td>".$comment."</td>";
                echo "<td>".$cdate."</td>";
                echo "<td><a href='ARReview.php?delete=".$rid."' onclick='return confirm(\"Are you sure you want to delete this review?\")' style='color: #c82a44;'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No customer comments found.";
        }

        mysqli_close($connect);
        ?>
    </div>
    <center>
        <p style="font-size: 15px;">
            Click here to <a href="logout.php" title="Logout" style="font-size: 15px; color: red;">Logout</a>
        </p>
    </center>
</body>
</html>
