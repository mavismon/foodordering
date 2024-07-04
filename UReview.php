<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "foodorder";
    $table_name = "review";

    $connect = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to the database");

    $nameErr = $emailErr = $pnameErr = $commentErr = "";
    $valid = true;

    if (empty($_POST["cname"])) {
        $nameErr = "Please enter a customer name";
        $valid = false;
    }

    if (empty($_POST["email"])) {
        $emailErr = "Please enter an email";
        $valid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    }

    if (empty($_POST["pname"])) {
        $pnameErr = "Please enter a product name";
        $valid = false;
    }

    if (empty($_POST["comment"])) {
        $commentErr = "Please enter a comment";
        $valid = false;
    }

    if ($valid) {
        $cname = $_POST["cname"];
        $email = $_POST["email"];
        $pname = $_POST["pname"];
        $comment = $_POST["comment"];

        $sql = "INSERT INTO $table_name (customer, email, productname, comment, Date)
                VALUES ('$cname', '$email', '$pname', '$comment', NOW())";

        if (!mysqli_query($connect, $sql)) {
            die('Error: ' . mysqli_error($connect));
        } else {
            $successMessage = "Thank you for giving comments";
        }

        mysqli_close($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="order.css">
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #CABEC1;
}

.container {
    max-width: 400px;
    margin: 0 auto;
    padding: 15px;
    background-color: #CABEC1;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    text-align: center;
}

.container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    margin-right:1000px;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="product"],
.form-group input[type="comment"] {
    width: 100%; /* Set initial width to 100% */
    box-sizing: border-box; /* Include padding and border in the width calculation */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}


.error-message {
    color: #dc3545;
    margin-top: 5px;
    font-size: 14px;
    text-align: left;
}

.success-message {
    color: #7D3A2A;
    font-size: 16px;
    text-align: center;
    margin-bottom: 10px;
    font-weight: bold;
}


.button-group {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.submit-btn {
    background-color: #745954;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
}

.reset-btn {
    background-color: #745954;
}

.submit-btn:hover,
.reset-btn:hover {
    background-color: #7D3A2A;
}

    </style>
    
 <script>
        function validateForm() {
            var cname = document.forms["reviewForm"]["cname"].value.trim();
            if (cname === '') {
                alert('Please enter a customer name');
                return false;
            }

            var email = document.forms["reviewForm"]["email"].value.trim();
            if (email === '') {
                alert('Please enter an email');
                return false;
            } else if (!validateEmail(email)) {
                alert('Invalid email format');
                return false;
            }

            var pname = document.forms["reviewForm"]["pname"].value.trim();
            if (pname === '') {
                alert('Please enter a product name');
                return false;
            }

            var comment = document.forms["reviewForm"]["comment"].value.trim();
            if (comment === '') {
                alert('Please enter a comment');
                return false;
            }

            return true;
        }

        function validateEmail(email) {
            // Email validation logic
            // This is a simple example, you can use more complex validation logic if needed
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
  
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
                <a href="home.html">Home</a>
                <a href="About.html">About</a>
                <a href="UPView.php">Food</a>
                <a href="Order.php">Order</a>
                <a href="UReview.php">Review</a>
                <a href="login.php">Admin Log In</a>
            </div>
        </div>
    </nav>


    <div class="container">
        <form name="reviewForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
            <h2 class="text-center">Review Form</h2>

            <div class="form-group">
                <label for="customername">Name:</label>
                <input type="text" name="cname" id="customer">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="form-group">
                <label for="product">Product:</label>
                <input type="text" name="pname" id="productname">
            </div>

            <div class="form-group">
                <label for="comment">Comment:</label>
                <input type="text" name="comment" id="comment">
            </div>

            
            <?php if (isset($successMessage)) : ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
              
            <?php endif; ?>

            <div class="form-group button-group">
                <input type="submit" name="submit" value="Submit" class="submit-btn">
                <input type="reset" value="Reset Form" class="submit-btn reset-btn">
            </div>

            
        </form>
    </div>
</body>
</html>
