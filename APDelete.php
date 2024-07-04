<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="Order.css"/>
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

        img.product-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        a.delete-link {
            color: #c82a44;
            text-decoration: none;
        }

        a.delete-link:hover {
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
                <a href="APAdd.php">Add Products</a>
                <a href="APEdit.php">Edit Products</a>
                <a href="APDelete.php" class="active">Delete Products</a>
                <a href="AOView.php">View Orders</a>
                <a href="ARReview.php">Review</a>
              
            </div>
        </div>
    </nav>

    <div class="container">
    <h2 class="text-center">Product Lists</h2>

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
    // PHP code for fetching products
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "foodorder";                        
    $conn = mysqli_connect($host, $user, $passwd, $database) 
        or die("Could not connect to the database");

    // Handle product deletion
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Delete the product from the database
        $delete_query = "DELETE FROM product WHERE productid = '$delete_id'";
        $result = mysqli_query($conn, $delete_query);

        if ($result) {
            echo "<p align='center'>Product deleted successfully.</p>";
        } else {
            echo "<p align='center'>Failed to delete the product.</p>";
        }
        exit; // Exit after deleting the product
    }

    // Fetch and display product list
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $query = "SELECT * FROM product";
    if (!empty($search)) {
        $query .= " WHERE productname LIKE '%$search%'";
    }
    
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Product ID</th><th>Category</th><th>Product Name</th><th>Price</th><th>Photo</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $pid = $row['productid'];
            $pcat = $row['catname'];
            $pname = $row['productname'];
            $price = $row['price'];
            $photo = $row['photo'];

            echo "<tr>";
            echo "<td>".$pid."</td>";
            echo "<td>".$pcat."</td>";
            echo "<td>".$pname."</td>";
            echo "<td>$".number_format($price, 2)."</td>";

            echo "<td><img src='".$photo."' alt='".$pname."' class='product-photo'></td>";
            echo "<td><a href='APDelete.php?delete_id=".$pid."' onclick='return confirm(\"Are you sure you want to delete this product?\");' class='delete-link'>Delete</a></td>";
            echo "</tr>";
        }
       
    } else {
        echo "<tr><td colspan='6' align='center'>No products found</td></tr>";
    }
    echo "</table>";

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