<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="order.css"/>
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
            object-fit: cover;
            border-radius: 4px;
        }

        .edit-link {
            color: #c82a44;
            text-decoration: none;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        .edit-form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-top:10px;
        }

        .form-group .btn-primary {
            width: 105%;
            padding: 10px;
            background-color: #745954;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group .btn-primary:hover {
            background-color: #7D3A2A;
        }

        .search-form {
            display: flex;
            flex-direction: column;
            max-width: 600px;
            margin: 0 auto;
            margin-top: 30px;
        }

        .search-form .form-group {
            display: flex;
            flex-direction: row;
        }
        .search-form label{
            margin-top:20px;
        }

        .search-form .form-group input[type="text"] {
    flex-grow: 1;
    margin-right: 10px;
    font-size: 14px; /* Adjust the font size as per your requirement */
    height: 20px;
    width:10px;  /* Adjust the height as per your requirement */
}

.search-form .form-group .btn-primary {
   
    padding: 10px;
    margin-top: 10px; /* Adjust the margin as per your requirement */
    font-size: 14px; /* Adjust the font size as per your requirement */
    height: 35px;
    width:100px; /* Adjust the height as per your requirement */
}


        .search-form .form-group .btn-primary:hover {
            background-color: #7D3A2A;
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
            <a href="APEdit.php" class="active">Edit Products</a>
            <a href="APDelete.php">Delete Products</a>
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
                <label for="search">Product Name:</label>
                <input type="text" id="search" name="search" placeholder="Enter product name" size="30px">
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
$conn = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to the database");

// Function to sanitize user inputs
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

// Function to validate required fields
function validateRequired($value, $fieldName)
{
    if (empty($value)) {
        return "$fieldName is required.";
    }
    return null;
}

// Function to validate numeric fields
function validateNumeric($value, $fieldName)
{
    if (!is_numeric($value)) {
        return "$fieldName must be a valid number.";
    }
    return null;
}

// Function to validate file uploads
function validateFile($file, $fieldName)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading $fieldName. Please try again.";
        return false;
    }
    return null;
}


// Fetch and display product list
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';

if (isset($_POST['submit'])) {
    $edit_id = sanitizeInput($_POST['edit_id']);
    $catname = sanitizeInput($_POST['catname']);
    $productname = sanitizeInput($_POST['productname']);
    $price = sanitizeInput($_POST['price']);
    $new_photo = $_FILES['new-photo'];

    // Validate required fields
    $errors = [];
    $errors['catname'] = validateRequired($catname, 'Category');
    $errors['productname'] = validateRequired($productname, 'Product Name');
    $errors['price'] = validateRequired($price, 'Price');

    // Validate data types
    $errors['price'] = validateNumeric($price, 'Price');

    // Validate file uploads
    $errors['new-photo'] = validateFile($new_photo, 'New Photo');

    $errorFound = false;

    $errorMessage = '';


    foreach ($errors as $field => $error) {
        if ($error !== null) {
            $errorFound = true;
            $errorMessage = $error;
            break;
        }
    }

    if (!$errorFound) {
        // Perform database update
        $fetch_query = "SELECT photo FROM product WHERE productid='$edit_id'";
        $result = mysqli_query($conn, $fetch_query);
        $row = mysqli_fetch_assoc($result);
        $photo = $row['photo'];

        $update_query = "UPDATE product SET catname='$catname', productname='$productname', price='$price'";
        if ($new_photo['error'] === UPLOAD_ERR_OK) {
            $target_dir = "image/";  
            $target_file = $target_dir . basename($new_photo['name']);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $target_file = $target_dir . uniqid() . '.' . $imageFileType;

            move_uploaded_file($new_photo['tmp_name'], $target_file);
            $update_query .= ", photo='$target_file'";

            // Delete the old photo if it's different from the new photo
            if (file_exists($photo) && $photo !== $target_file && file_exists($photo)) {
                unlink($photo);
            }
        }
        $update_query .= " WHERE productid='$edit_id'";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Product updated successfully');</script>";
            echo "<script>window.location.href = 'APEdit.php';</script>";
        } else {
            echo "<script>alert('Failed to update product');</script>";
        }
    } 
}
if (!empty($errorMessage)) {
    echo "<script>alert('$errorMessage');</script>";
}

        
    


$fetch_query = "SELECT * FROM product";
if (!empty($search)) {
    $fetch_query .= " WHERE productname LIKE '%$search%'";
}
$result = mysqli_query($conn, $fetch_query);

echo "<table>";
echo "<tr>
        <th>Product ID</th>
        <th>Category</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Photo</th>
        <th>Action</th>
    </tr>";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $photo = $row['photo'];
        $price = $row['price'];
        echo "<tr>";
        echo "<td>" . $row['productid'] . "</td>";
        echo "<td>" . $row['catname'] . "</td>";
        echo "<td>" . $row['productname'] . "</td>";
        echo "<td>$" . number_format($price, 2) . "</td>";

        echo "<td><img src='" . $photo . "' width='100px' height='100px' alt='Product Photo' class='product-photo'></td>";
        echo "<td><a href='APEdit.php?edit_id=" . $row['productid'] . "&search=$search' class='edit-link'>Edit</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' align='center'>No products found</td></tr>";
}
echo "</table>";

// Edit product functionality
if (isset($_GET['edit_id'])) {
    $edit_id = sanitizeInput($_GET['edit_id']);
    $fetch_query = "SELECT * FROM product WHERE productid='$edit_id'";
    $edit_result = mysqli_query($conn, $fetch_query);

    if (mysqli_num_rows($edit_result) > 0) {
        $edit_row = mysqli_fetch_assoc($edit_result);
        ?>
        <h2 class="text-center">Edit Product</h2>
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="edit-form">

                <div class="form-group">
                    <label for="catname">Category:</label>
                    <input type="text" id="catname" name="catname" value="<?php echo $edit_row['catname']; ?>">
                </div>
                <div class="form-group">
                    <label for="productname">Product Name:</label>
                    <input type="text" id="productname" name="productname" value="<?php echo $edit_row['productname']; ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" value="<?php echo $edit_row['price']; ?>">
                </div>
                <div class="form-group">
                    <label for="new-photo">New Photo:</label>
                    <input type="file" id="new-photo" name="new-photo">
                </div>
                <div class="form-group text-center">
                    <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                </div>
            </div>
        </form>


        <?php
    } else {
        echo "<p align='center'>Product not found</p>";
    }
    
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

<script>
    function validateForm() {
        var catname = document.getElementById("catname").value;
        var productname = document.getElementById("productname").value;
        var price = document.getElementById("price").value;
        var newPhoto = document.getElementById("new-photo").value;

        if (catname.trim() === "") {
            alert("Category is required.");
            return false;
        }

        if (productname.trim() === "") {
            alert("Product Name is required.");
            return false;
        }

        if (price.trim() === "") {
            alert("Price is required.");
            return false;
        }

        if (isNaN(price)) {
            alert("Price must be a valid number.");
            return false;
        }

        if (newPhoto !== "") {
            var fileInput = document.getElementById("new-photo");
            var file = fileInput.files[0];
            var allowedExtensions = ["jpg", "jpeg", "png", "gif"];
            var fileExtension = file.name.split(".").pop().toLowerCase();

            if (!allowedExtensions.includes(fileExtension)) {
                alert("Invalid file format. Please select a JPG, JPEG, PNG, or GIF file.");
                return false;
            }

            var fileSize = file.size / 1024 / 1024; // Convert to MB

            if (fileSize > 5) {
                alert("File size exceeds the maximum limit of 5MB.");
                return false;
            }
        }

        return true;
    }
</script>
