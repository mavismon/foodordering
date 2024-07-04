<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="order.css"/>
    <style>
        .error {
            color: #FF0001;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #CABEC1;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            border-radius: 5px;
            padding: 20px;
            background-color: #CABEC1;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .container .entries {
            margin-top: 20px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container label {
            font-size: 15px;
            display: block;
        }

        .container input[type="text"],
        .container input[type="file"] {
            width: 100%;
            padding: 10px;
        }

        .container input[type="submit"],
        .container input[type="reset"] {
            padding: 10px 20px;
            background-color: #745954;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .container input[type="submit"]:hover,
        .container input[type="reset"]:hover {
            background-color: #7D3A2A;
        }
        .form-group {
            margin-bottom: 15px;
            margin-right:300px;
            size:50px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group input[type="text"] {
            width: 250%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .success-message {
        color: #7D3A2A;
        font-size: 16px;
        text-align: center;
        margin-bottom: 10px;
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
            <a href="APAdd.php">Add Products</a>
            <a href="APEdit.php">Edit Products</a>
            <a href="APDelete.php">Delete Products</a>
            <a href="AOView.php">View Orders</a>
            <a href="ARReview.php">Review</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="text-center">Add New Menu Here</h2>
    <?php
    if (isset($_POST['submit'])) {
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "foodorder";
        $table_name = "product";

        $connect = mysqli_connect($host, $user, $passwd, $database) or die("could not connect to database");

        $pcategory = $_POST['pcategory'];
        $pname = $_POST['pname'];
        $price = $_POST['price'];
        $target_dir = "image/";
        $target_file = $target_dir . $_FILES["pfile"]["name"];
        $maxsize = 5242880; // 5MB

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("png", "jpeg", "jpg");

        // Check extension
        if (in_array($imageFileType, $extensions_arr)) {
            // Check file size
            if (($_FILES['pfile']['size'] >= $maxsize) || ($_FILES["pfile"]["size"] == 0)) {
                echo "File too large. File must be less than 5MB.";
            } else {
                // Check if price is a positive integer
                if (!is_numeric($price) || intval($price) <= 0) {
                    echo '<script>alert("Invalid price. Price must be a positive integer.");</script>';
                } else {
                    // Insert record
                    $sql = "INSERT INTO $table_name (catname, productname, price, photo)
                            VALUES ('$pcategory', '$pname', '$price', '$target_file')";

                    if (!mysqli_query($connect, $sql)) {
                        die('Error: ' . mysqli_error($connect));
                    } else {
                        $message = "New Menu is successfully added";
                    }
                    mysqli_close($connect);
                }
            }
        } else {
            echo "Invalid file extension.";
        }
    }
    ?>

    <form name="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="pcategory">Category Name:</label>
            <input type="text" name="pcategory" id="pcategory" required>
        </div>
        <div class="form-group">
            <label for="pname">Product Name:</label>
            <input type="text" name="pname" id="pname" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" required>
        </div>
        <div class="form-group">
            <label for="pfile">Photo:</label>
            <input type="file" name="pfile" id="pfile" required>
        </div>

        <?php if (isset($message)) : ?>
                <p class="success-message"><?php echo $message; ?></p>
              
            <?php endif; ?>

        <div style="text-align: center;">
            <input type="submit" name="submit" value="Submit">
            <input type="reset" value="Reset Form">
        </div>
    </form>
</div>

<center>
    <p style="font-size: 15px;">
        Click here to <a href="logout.php" title="Logout" style="font-size: 15px; color: red;">Logout</a>
    </p>
</center>

</body>
</html>
