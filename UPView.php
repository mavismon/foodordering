
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Good Food Restaurant</title>
    <link rel="stylesheet" type="text/css" href="order.css">

          <style>
        body {
            font-family: Arial, sans-serif;
            background-color:  #CABEC1;
            margin: 0;
        }
        
        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #CABEC1;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }
        
        h1 {
            text-align: center;
            color: black;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .menu-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .menu-item {
        width: calc(23% - 20px); /* Adjusted width to 25% */
        margin: 10px;
        padding: 10px;
        background-color: #f2f2f2;
        border-radius: 3px;
        text-align: center;
}

        .menu-item img {
        width: 230px;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 10px;
        display: block;
        margin: 0 auto;
        }

        
        .menu-item h3 {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
        
        .menu-item p {
            margin: 5px 0;
            font-size: 14px;
            color: #888;
            line-height: 1.2;
        }
        
        .menu-item span {
            font-weight: bold;
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

<div class="content">
    <h1>Explore Our Menu Here</h1>
    <ul class="menu-items">
        <?php
        $host = "localhost";
        $user = "root";
        $passwd = "";
        $database = "foodorder";
        $table_name = "product";
        $connect = mysqli_connect($host, $user, $passwd, $database) 
            or die("Could not connect to the database");

        $query = "SELECT * FROM $table_name";
        mysqli_select_db($connect, $database);
        $result = mysqli_query($connect, $query);

        if ($result) {
            $count = 0;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $pname = $row['productname'];
                $price = $row['price'];
                $photo = $row['photo'];

                echo "<li class='menu-item'>";
                echo "<img src='".$photo."'>";
                echo "<h3>".$pname."</h3>";
                echo "<p><span>Price:</span> ".$price."</p>";
                echo "</li>";

                $count++;
                if ($count == 5) {
                    echo "<br>";
                    $count = 0;
                }
            }
        } else {
            die("Query=$query failed!");
        }

        mysqli_close($connect);
        ?>
    </ul>
</div>

</body>
</html>
