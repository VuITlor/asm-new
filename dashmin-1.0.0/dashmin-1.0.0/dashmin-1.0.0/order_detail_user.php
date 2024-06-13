<?php
session_start();
include_once('./DBUtil.php');
include_once('../config/status_orderconfig.php');

$dbHelper = new DBUntil();
$order_id = $_POST['id'];
// Lấy dữ liệu từ bảng orders và order_details
$orders = $dbHelper->selectOne(" SELECT * FROM orders WHERE order_id = '$order_id' ");
$order_detail = $dbHelper->select(" SELECT * FROM order_details WHERE order_id = '$order_id' ");

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
    <a href="order.php" class="btn btn-primary" style="margin-bottom: 10px">Back</a>
        <section class="h-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-10 col-xl-8">
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-header px-4 py-5">
                                <h5 class="text-muted mb-0">Detail Order:</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <p class="lead fw-normal mb-0" style="color: #a8729a;">Receipt</p>
                                    <p class="small text-muted mb-0">Receipt Voucher : 1KAU9-84UIL</p>
                                </div>


                                <div class="d-flex justify-content-between pt-2">
                                    <p class="fw-bold mb-0">Order Details</p>
                                    <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span><?php echo $orders['total_amount']; ?></p>
                                </div>

                                <div class="d-flex justify-content-between pt-2">
                                    <p class="text-muted mb-0">Order Number : <?php echo $orders['order_id']; ?></p>
                                    <p class="text-muted mb-0"><span class="fw-bold me-4">Name</span> <?php echo $orders['customer_name']; ?></p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="text-muted mb-0">Address: <?php echo $orders['customer_address']; ?></p>
                                    <p class="text-muted mb-0">Phone: <?php echo $orders['customer_phone']; ?></p>
                                </div>

                                <div class="d-flex justify-content-between mb-5">
                                    <p class="text-muted mb-0"><?php echo $orders['created_at']; ?></p>
                                    <p class="text-muted mb-0">Status: <?php echo getStatusText($orders['status']); ?></p>
                                </div>

                                <div class="card shadow-0 border mb-4">
                                    <?php
                                    foreach ($order_detail as $key => $value) {
                                    ?> <div class="card-body">
                                            <div class="row">
                                                <!-- <div class="col-md-2">
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/1.webp" class="img-fluid" alt="Phone">
                                                </div> -->
                                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0"><?php echo $value['product_name']; ?></p>
                                                </div>
                                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">Price: <?php echo $value['product_name']; ?></p>
                                                </div>
                                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">Quantity: <?php echo $value['quantity']; ?></p>
                                                </div>
                                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">Total: <?php echo $value['total']; ?></p>
                                                </div>
                                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">Total amount: <?php echo $value['total_amount']; ?></p>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card-footer border-0 px-4 py-5" style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                                    paid: <span class="h2 mb-0 ms-2"><?php echo $orders['total_amount']; ?></span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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