<?php

include_once('./DBUtil.php');
include_once('./cart/cart.php');
ini_set('display_errors', '1');
$user = $_SESSION['user'];
$dbHelper = new DBUntil();
$categories = $dbHelper->select("SELECT * FROM products");
$errors = [];
$carts = new Cart();
$discount = 0;
$sale = 0;
$total = 0;
if (isset($_POST['sale']) && !empty($_POST['sale'])) {
    $sale = $_POST['sale'];
}
if (isset($_POST['total']) && !empty($_POST['total'])) {
    $total = $_POST['total'];
}

if (isset($_SESSION['discount'])) {
    $discount = $_SESSION['discount'];
}
function checkCode($code)
{
    global $dbHelper;
    $sql = $dbHelper->select(
        "SELECT * FROM coupons WHERE code = :code AND quantity > 0 AND 
        startDate <= :currentDate AND endDate >= :currentDate",
        array(
            'code' => $code,
            'currentDate' => date("Y-m-d")
        )
    );
    return count($sql) > 0 ? $sql[0] : null;
}
$orderCreated = isset($_SESSION['order_created']) && $_SESSION['order_created'];
unset($_SESSION['order_created']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'checkCode') {
            if (!empty($_POST['code'])) {
                $isCheck = checkCode($_POST['code']);
                if (!empty($isCheck)) {
                    $_SESSION['discount'] = $isCheck['discount'];
                    $_SESSION['coupon_code'] = $isCheck['code'];
                    $discount = $isCheck['discount'];
                }
            }
        } elseif ($_POST['action'] == 'checkout') {
            $customer_name = $_POST['middleName'] . ' ' . $_POST['name'];
            $customer_email = $_POST['email'];
            $customer_phone = $_POST['phone'];
            $customer_address = $_POST['address'];
            $payment_method = $_POST['paymentMethod'];
            $total_amount = $_POST['total'];
            $discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : '';

            $order_id = $dbHelper->insert("orders", array(
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'customer_phone' => $customer_phone,
                'customer_address' => $customer_address,
                'payment_method' => $payment_method,
                'total_amount' => $total_amount,
                'discount' => $discount,
                'user_id' => $user['id'],
                'coupon_code' => isset($_SESSION['coupon_code']) ? $_SESSION['coupon_code'] : null

            ));

            foreach ($carts->getCart() as $item) {
                $subTotal = $item['quantity'] * $item['price'];
                $dbHelper->insert("order_details", array(
                    'order_id' => $order_id,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $subTotal,
                    'total_amount' => $total_amount,
                    'customer_name' => $customer_name,
                    'customer_email' => $customer_email,
                    'customer_phone' => $customer_phone,
                    'customer_address' => $customer_address,
                ));
            }

            header("Location: index_user.php");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./cart.css">
</head>

<body>
    <div class="container">
        <a href="index_cart.php" class="btn btn-primary">Back to CheckOut</a>
        <div class="py-5 text-center">
            <h2>Checkout form</h2>
        </div>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                </h4>
                <ul class="list-group mb-3">
                    <?php
                    foreach ($carts->getCart() as $item) {
                        $subTotal = $item['quantity'] * $item['price'];
                        echo "<li class='list-group-item d-flex justify-content-between lh-condensed'>";
                        echo "<div>";
                        echo "<h6 class='my-0'>$item[name]</h6>";
                        echo "<td>";
                        if (isset($item['image']) && !empty($item['image'])) {
                            echo "<img src='" . htmlspecialchars($item['image']) . "' alt='" . htmlspecialchars($item['name']) . "' class='img-fluid' style='max-width: 50px;'>";
                        }
                        echo "</td>";
                        echo "<small class='text-muted'>Quantity: $item[quantity]</small>";
                        echo "</div>";
                        echo "<span class='text-muted'>$item[price]</span>";
                        echo "</li>";
                    }
                    ?>
                </ul>
                <div class="list-group mb-3">
                    <span>Discount: <span class="text-medium"><?php echo  $sale  ?></span> <br>
                        <span>Total: <span class="text-medium"><?php echo $total ?></span></span>
                </div>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Customer Information</h4>
                <form class="needs-validation" novalidate action="" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="hidden" value="<?php echo  $total  ?>" name="total" required>
                            <label for="middleName">Họ</label>
                            <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Nguyễn Văn" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Tên</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="A" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone number" required>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                    </div>
                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="same-address">
                        <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="save-info">
                        <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div>
                    <hr class="mb-4">
                    <h4 class="mb-3">Payment</h4>
                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" value="COD" checked required>
                            <label class="custom-control-label" for="credit">COD</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" value="VNPAY" required>
                            <label class="custom-control-label" for="paypal">VNPAY</label>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" name="action" value="checkout" type="submit">Continue to checkout</button>
                </form>
            </div>
            <?php if ($orderCreated) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your order has been created successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
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