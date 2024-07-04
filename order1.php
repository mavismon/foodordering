<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$passwd = "";
$database = "foodorder";
$conn = mysqli_connect($host, $user, $passwd, $database) or die("Could not connect to the database.");

if (isset($_POST['productid'])) {
    $customer = $_POST['customer'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $remarks = $_POST['remarks'];

    // Prepare the INSERT statement for purchase
    $insertPurchaseStmt = $conn->prepare("INSERT INTO purchase (customer, date_purchase, address, phone, email, remarks) VALUES (?, NOW(), ?, ?, ?, ?)");
    if (!$insertPurchaseStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $insertPurchaseStmt->bind_param("sssss", $customer, $address, $phone, $email, $remarks);
    if (!$insertPurchaseStmt->execute()) {
        die("Execute failed: (" . $insertPurchaseStmt->errno . ") " . $insertPurchaseStmt->error);
    }

    $purchaseId = $conn->insert_id;
    $total = 0;

    foreach ($_POST['productid'] as $product) {
        $productInfo = explode("||", $product);
        $productId = $productInfo[0];
        $iteration = $productInfo[1];

        $sql = "SELECT * FROM product WHERE productid = ?";
        $query = $conn->prepare($sql);
        $query->bind_param("i", $productId);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        if (isset($_POST['quantity_' . $iteration])) {
            $quantity = $_POST['quantity_' . $iteration];
            $subTotal = $row['price'] * $quantity;
            $total += $subTotal;

            // Prepare the INSERT statement for purchase_detail
            $insertDetailStmt = $conn->prepare("INSERT INTO purchase_detail (purchaseid, productid, quantity, subtotal) VALUES (?, ?, ?, ?)");
            if (!$insertDetailStmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $insertDetailStmt->bind_param("iiid", $purchaseId, $productId, $quantity, $subTotal);
            if (!$insertDetailStmt->execute()) {
                die("Execute failed: (" . $insertDetailStmt->errno . ") " . $insertDetailStmt->error);
            }
        }
    }

    // Update the total in the purchase table
    $updateTotalStmt = $conn->prepare("UPDATE purchase SET total = ? WHERE purchaseid = ?");
    if (!$updateTotalStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $updateTotalStmt->bind_param("di", $total, $purchaseId);
    if (!$updateTotalStmt->execute()) {
        die("Execute failed: (" . $updateTotalStmt->errno . ") " . $updateTotalStmt->error);
    }

    session_start();
    $_SESSION['sess_pid'] = $purchaseId;
    $_SESSION['total'] = $total;
    $_SESSION['order_time'] = time();

    header('location: ordersuccess.php');
} else {
    ?>
    <script>
        window.alert('Please select a product');
        window.location.href = 'order.php';
    </script>
    <?php
}
?>
