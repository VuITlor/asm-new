<?php
session_start();
include_once('./DBUtil.php');
include_once('../config/status_orderconfig.php');

// Khởi tạo đối tượng DBUtil để làm việc với cơ sở dữ liệu
$dbHelper = new DBUntil();

// Lấy dữ liệu từ bảng orders và order_details
$orders = $dbHelper->select("
    SELECT o.order_id AS order_id, o.customer_name, o.customer_email, o.customer_phone, o.customer_address, o.payment_method, 
           o.total_amount, o.discount, o.coupon_code, o.created_at, o.status, od.product_name, od.quantity, od.price, od.total
    FROM orders o
    JOIN order_details od ON o.order_id = od.order_id
    ORDER BY o.order_id DESC
");

// Tính tổng doanh thu từ các đơn hàng đã giao thành công (status = 4)
$totalRevenue = 0;
// Đếm số đơn hàng đã xử lý (status khác 0)
$totalProcessedOrders = 0;

foreach ($orders as $order) {
    // Tính tổng doanh thu
    if ($order['status'] == 4) {
        $totalRevenue += $order['total'];
    }

    // Đếm số đơn đã xử lý
    if ($order['status'] != 1 && $order['status'] != 0 && $order['status'] != 2) {
        $totalProcessedOrders++;
    }
}

// Hàm để lấy trạng thái của đơn hàng từ file status_orderconfig.php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="text-center">
            <h2>Order Details</h2>
            <a href="index.php" class="btn btn-primary">Back to Index</a>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <?php if (!empty($orders)) : ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Coupon Code</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_address']); ?></td>
                                    <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                    <td><?php echo number_format($order['total_amount'], 2); ?> VND</td>
                                    <td><?php echo number_format($order['discount'], 2); ?>%</td>
                                    <td><?php echo htmlspecialchars($order['coupon_code']); ?></td>
                                    <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['created_at']; ?></td>
                                    <td><?php echo number_format($order['price'], 2); ?> VND</td>
                                    <td><?php echo number_format($order['total'], 2); ?> VND</td>
                                    <td><?php echo getStatusText($order['status']); ?></td>
                                    <td>
                                        <form action="update_status.php" method="post">
                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                            <select name="status" class="form-select">
                                                <option value="1" <?php if ($order['status'] == 1) echo 'selected'; ?>>Chưa giải quyết</option>
                                                <option value="2" <?php if ($order['status'] == 2) echo 'selected'; ?>>Đang xử lý</option>
                                                <option value="3" <?php if ($order['status'] == 3) echo 'selected'; ?>>Đang vận chuyển</option>
                                                <option value="4" <?php if ($order['status'] == 4) echo 'selected'; ?>>Đã giao hàng</option>
                                                <option value="5" <?php if ($order['status'] == 5) echo 'selected'; ?>>Đã hủy</option>
                                                <option value="6" <?php if ($order['status'] == 6) echo 'selected'; ?>>Hoàn trả</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Hiển thị tổng doanh thu và số đơn hàng đã xử lý -->
                    <div class="alert alert-success mt-4">
                        <h4 class="alert-heading">Tổng doanh thu</h4>
                        <p><?php echo number_format($totalRevenue, 2); ?> VND</p>
                        <hr>
                        <h4 class="alert-heading">Tổng số đơn đã xử lý</h4>
                        <p><?php echo $totalProcessedOrders; ?></p>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning mt-4" role="alert">
                        Không có đơn hàng nào để hiển thị.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2024 Company Name</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
</body>

</html>
