<?php
session_start();
include_once('./DBUtil.php');

$dbHelper = new DBUntil();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Validate input (you may add more validation as per your requirements)

    // Update order status in the database
    $updated = $dbHelper->updateOrderStatus($order_id, $status);

    if ($updated) {
        $_SESSION['message'] = "Trạng thái của đơn hàng đã được cập nhật thành công.";
    } else {
        $_SESSION['message'] = "Cập nhật trạng thái đơn hàng không thành công.";
    }

    // Redirect back to order_details.php or any other page
    header("Location: order_details.php");
    exit();
} else {
    $_SESSION['message'] = "Phương thức không hợp lệ.";
    header("Location: order_details.php");
    exit();
}
?>
