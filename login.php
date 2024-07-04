<?php
$validUser = false; // Assuming user validation logic is implemented elsewhere

if (isset($_POST["submit"])) {
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $con = mysqli_connect('localhost', 'root', '', 'foodorder') or die(mysql_error());
        $query = mysqli_query($con, "SELECT * FROM users WHERE username='" . $user . "' AND password='" . $pass . "'");
        $numrows = mysqli_num_rows($query);
        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
            }
          
            if ($user == $dbusername && $pass == $dbpassword) {
                session_start();
                $_SESSION['sess_user'] = $user;
                echo '<script>alert("Welcome Admin");</script>';
                echo '<script>window.location.href = "APView.php";</script>';
                exit(); 
            }
            
        } else {
            echo '<script>alert("Invalid username and password");</script>';
        }
    } else {
        echo '<div class="container">';
        echo '<h2 class="text-center">ADMIN LOG IN</h2>';
        echo '<div class="error-message">All fields are required!</div>';
        echo '</div>';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="order.css"/>
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


        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            margin-right:300px;
            
            
        }
        .button-group {
    display: flex;
    jiustify-content: center;
    margin-top: 20px;
   margin-left:80px;
}


        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;

        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 380%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .error-message {
            color: #dc3545;
            margin-top: 5px;
            font-size: 14px;
        }

        .submit-btn {
            background-color: #745954;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right:50px;
        }

        .reset-btn {
            margin-left: 10px;
            background-color: #745954;
            margin-right:50px;
        }

        .submit-btn:hover,
        .reset-btn:hover
        {
            background-color: #7D3A2A;
        }
        .error-message {
        color: #dc3545;
        margin-top: 5px;
        font-size: 14px;
        text-align: left; /* Add this line to align the error messages to the left */
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
         <a href="home.html">Home</a>
         <a href="About.html">About</a>
         <a href="UPView.php">Food</a>
         <a href="Order.php">Order</a>
         <a href="UReview.php">Review</a>
         <a href="login.php">Admin Log In</a>
       </div>
     </div>
   </nav>

 </body>
 
 <div class="container">
       <h2 class="text-center">ADMIN LOG IN</h2>
       <form action="" method="POST" onsubmit="return validateForm()">

       
           <div class="form-group">
               <label for="username">Username:</label>
               <input type="text" name="user" id="username">
               <?php if(isset($_POST["submit"]) && empty($user)): ?>
                   <div class="error-message">Please enter a username.</div>
               <?php endif; ?>
           </div>

           <div class="form-group">
               <label for="password">Password:</label>
               <input type="password" name="pass" id="password">
           </div>

           <div class="form-group button-group">
               <input type="submit" name="submit" value="Submit" class="submit-btn">
               <input type="reset" value="Reset Form" class="submit-btn reset-btn">
           </div>
       </form>
   </div>

   <script>
       function validateForm() {
           var username = document.getElementById('username').value.trim();
           if (username === '') {
               alert('Please enter a username');
               return false;
           }

           var password = document.getElementById('password').value.trim();
           if (password === '') {
               alert('Please enter a password');
               return false;
           }
           
       }
   </script>
</body>
</html>