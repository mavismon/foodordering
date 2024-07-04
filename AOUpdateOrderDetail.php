<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchaseid = $_POST['purchaseid'];
    $productid = $_POST['productid'];
    $quantity = $_POST['quantity'];

    // Validate and sanitize the input (example: check if quantity is a positive integer)
    if ($quantity == 0) {
        echo '<script>alert("Error: Quantity cannot be zero."); window.location.href = "AOViewDetail.php?purchaseid=' . $purchaseid . '";</script>';
        exit();
    }

    

    // Perform necessary database operations to update the purchase detail record
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $database = "foodorder";
    $conn = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to the database");

    // Fetch the updated product price
    $productSql = "SELECT price FROM product WHERE productid = '$productid'";
    $productQuery = mysqli_query($conn, $productSql);
    $productRow = mysqli_fetch_assoc($productQuery);
    $price = $productRow['price'];

    // Fetch the original subtotal of the purchase detail
    $originalSubtotalSql = "SELECT subtotal FROM purchase_detail WHERE purchaseid = '$purchaseid' AND productid = '$productid'";
    $originalSubtotalQuery = mysqli_query($conn, $originalSubtotalSql);
    $originalSubtotalRow = mysqli_fetch_assoc($originalSubtotalQuery);
    $originalSubtotal = $originalSubtotalRow['subtotal'];

    // Update the purchase detail quantity and recalculate the subtotal
    $updateSql = "UPDATE purchase_detail SET quantity = '$quantity', subtotal = quantity * $price WHERE purchaseid = '$purchaseid' AND productid = '$productid'";
    $updateQuery = mysqli_query($conn, $updateSql);

    if ($updateQuery) {
        // Update successful

        // Calculate the difference in subtotal
        $subtotalDifference = ($quantity * $price) - $originalSubtotal;

        // Fetch the current total order amount by summing the subtotals of all purchase details
        $totalOrderSql = "SELECT SUM(subtotal) AS total FROM purchase_detail WHERE purchaseid = '$purchaseid'";
        $totalOrderQuery = mysqli_query($conn, $totalOrderSql);
        $totalOrderRow = mysqli_fetch_assoc($totalOrderQuery);
        $totalOrder = $totalOrderRow['total'];

        // Update the total order in the purchase table
        $updateTotalSql = "UPDATE purchase SET total = '$totalOrder' WHERE purchaseid = '$purchaseid'";
        $updateTotalQuery = mysqli_query($conn, $updateTotalSql);

        if ($updateTotalQuery) {
            // Total update successful
            header("Location: AOViewDetail.php?purchaseid=$purchaseid");
            exit();
        } else {
            // Total update failed
            echo "Failed to update the total order.";
        }
    } else {
        // Update failed
        echo "Failed to update the purchase detail.";
    }

    mysqli_close($conn);
} else {
    header("Location: AOView.php");
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Update Purchase Detail</title>
</head>
<body>
    <h2>Update Purchase Detail</h2>
    <form method="POST" action="AOUpdateOrderDetail.php">
        <label for="purchaseid">Purchase ID:</label>
        <input type="hidden" id="purchaseid" name="purchaseid" value="<?php echo $_GET['purchaseid']; ?>">

        <table>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
            <!-- Populate table with purchase detail rows -->
        </table>

        <button type="submit">Update</button>
    </form>
</body>
</html>

