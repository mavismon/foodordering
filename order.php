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

        input[type="checkbox"] {
            margin-left: 8px;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-row input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #555;
            margin-top: 5px;
        }

        .form-row label {
            flex-basis: 150px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #745954;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 20px;
            box-sizing: border-box;
        }

        .btn-submit:hover {
            background-color: #7D3A2A;
        }

        /* CSS for photo column */
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

        select[name^="quantity_"] {
            width: 150px;
            height: 29px;
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #555;
            margin-top: 5px;
        }
        .btn-cancel {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #745954;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 10px;
            box-sizing: border-box;
        }

        .btn-cancel:hover {
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
        <h2 class="text-center">You can order here</h2>
        <form method="POST" action="Order1.php" onsubmit="return validateForm()">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php  
                    // PHP code for fetching products
                    $host = "localhost";
                    $user = "root";
                    $passwd = "";
                    $database = "foodorder";                        
                    $conn = mysqli_connect($host,$user,$passwd,$database) 
                    or die("could not connect to database");
                    $sql="select * from product order by productname asc";                    
                    $query=$conn->query($sql);
                    $iterate=0;
                    while($row=$query->fetch_array()){
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $row['productid']; ?>||<?php echo $iterate; ?>" name="productid[]">
                            </td>
                            <td class="photo-column"><img src="<?php echo $row['photo']; ?>" alt="<?php echo $row['productname']; ?>"></td>
                            <td><?php echo $row['catname']; ?></td>
                            <td><?php echo $row['productname']; ?></td>
                            <td>$ <?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <select name="quantity_<?php echo $iterate; ?>">
                                    <option value=""></option>
                                    <?php  
                                    // Generate dropdown options for quantity
                                    for($i=1; $i<=100; $i++){
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                        $iterate++;
                    }
                    ?>              
                </tbody>
            </table>

            <div class="form-row">
            <label for="customer">Customer Name:</label>
            <input type="text" name="customer" id="customer" >
        </div>

        <div class="form-row">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" >
        </div>

        <div class="form-row">
            <label for="Phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" >
        </div>

        <div class="form-row">
            <label for="email">Email Address:</label>
            <input type="text" name="email" id="email" >
        </div>

        <div class="form-row">
                <label for="remarks">Remarks</label>
                <input type="text" name="remarks" id="remarks"  placeholder="Remark is Optional"></textarea>
            </div>

        <div class="form-row">
            <button type="submit" class="btn-submit">Submit Order</button>
        </div>
    </form>

</div>



<script>
function validateForm() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            var quantity = document.querySelector('select[name="quantity_' + checkboxes[i].value.split("||")[1] + '"]').value;
            if (quantity === "") {
                alert("Please select quantity for all selected products");
                return false;
            }
        }
    }
    if (!checked) {
        alert('Please select at least one product');
        return false;
    }

    if (!checked) {
            alert('Please select at least one product');
            return false;
        }

        // Check if customer name is not empty
        var customer = document.getElementById('customer').value.trim();
        if (customer === '') {
            alert('Please enter customer name');
            return false;
        }

        // Check if address is not empty
        var address = document.getElementById('address').value.trim();
        if (address === '') {
            alert('Please enter address');
            return false;
        }

        // Check if phone number is not empty and valid
        var phone = document.getElementById('phone').value.trim();
        if (phone === '') {
            alert('Please enter phone number');
            return false;
        }
        // Assuming phone number should be numeric with 10 digits
        if (!/^\d{10}$/.test(phone)) {
            alert('Please enter a valid 10-digit phone number');
            return false;
        }

        // Check if email is not empty and valid
        var email = document.getElementById('email').value.trim();
        if (email === '') {
            alert('Please enter email address');
            return false;
        }
        // Assuming a simple email validation (not thorough)
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert('Please enter a valid email address');
            return false;
        }
        var remarks = document.getElementById('remarks').value.trim();
        if (remarks !== '' && remarks.length > 200) {
            alert('Remarks cannot exceed 200 characters');
            return false;
    }


    return true;
}


</script>

</body>
</html>
