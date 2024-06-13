<?php
session_start();
include_once('./DBUtil.php');
include_once('../config/status_orderconfig.php');

$dbHelper = new DBUntil();

// Lấy dữ liệu từ bảng orders và order_details
$orders = $dbHelper->select("
    SELECT o.order_id AS order_id, o.customer_name, o.customer_email, o.customer_phone, o.customer_address, o.payment_method, 
           o.total_amount, o.discount, o.coupon_code, o.created_at, o.status, od.product_name, od.quantity, od.price, od.total
    FROM orders o
    JOIN order_details od ON o.order_id = od.order_id
    ORDER BY o.order_id DESC
");

// Tính tổng doanh thu
$totalRevenue = 0;
// Đếm số đơn đã đi
$totalProcessedOrders = 0;

foreach ($orders as $order) {
    if (in_array($order['status'], [4])) {   
        // Add order total to total revenue
        $totalRevenue += $order['total'];
    }

    // Increment total processed orders
    if ($order['status'] != 0) {
        $totalProcessedOrders++;
    }

    // Subtract order total if status is 5
    if ($order['status'] == 5) {
        $totalProcessedOrders--;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Order Details</h2>
            <!-- Back to Index Button -->
            <a href="index.php" class="btn btn-primary">Back to Index</a>
        </div>
        <div class="row">
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
                                <th scope="col">Day-time</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
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
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Total Revenue and Total Processed Orders -->
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Tổng doanh thu</h4>
                        <p><?php echo number_format($totalRevenue, 2); ?> VND</p>
                        <hr>
                        <h4 class="alert-heading">Tổng số đơn</h4>
                        <p><?php echo $totalProcessedOrders; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2017-2019 Company Name</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
</body>

</html>