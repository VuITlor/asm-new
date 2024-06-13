<?php
session_start();
include_once('./DBUtil.php');

$dbHelper = new DBUntil();

// Lấy dữ liệu từ bảng orders và order_details, nhóm theo khách hàng
$customers = $dbHelper->select("
    SELECT *
    FROM orders
");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customer Order List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Customer Order List</h2>
            <!-- Back to Index Button -->
            <a href="index.php" class="btn btn-primary">Back to Index</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($customers)) : ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Day-time</th>
                                <th scope="col">Address</th>
                                <th scope="col">Total Spent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_email']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_address']); ?></td>
                                    <td><?php echo number_format($customer['total_amount'], 2); ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="alert alert-info" role="alert">
                        No customers found.
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