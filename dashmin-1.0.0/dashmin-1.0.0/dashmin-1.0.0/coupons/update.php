<?php
include_once('../DBUtil.php');
ini_set('display_errors', '1');

$dbHelper = new DBUntil();

$errors = [];
$id = $_GET['id'];
$coupon = $dbHelper->select("SELECT * FROM coupons WHERE id = ?", [$id])[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["name"]) || empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    } else {
        $data = [
            'name' => $_POST['name'],
            'code' => $_POST['code'],
            'quantity' => $_POST['quantity'],
            'discount' => $_POST['discount'],
            'startDate' => $_POST['startDate'],
            'endDate' => $_POST['endDate']
        ];
        $condition = "id = $id";
        $updateResult = $dbHelper->update('coupons', $data, $condition);
        if (is_int($updateResult) && $updateResult > 0) {
            header("Location: ../index_cupons.php");
            exit();
        } else {
            $errors['db'] = "Error updating record: " . $updateResult;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Coupon</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <h2>Update Coupon</h2>
        <form action="update.php?id=<?php echo $id; ?>" method="post">
            <input type="text" name="name" class="form-control mt-3" required placeholder="Coupon Name" value="<?php echo htmlspecialchars($coupon['name']); ?>">
            <input type="text" name="code" class="form-control mt-3" required placeholder="Coupon Code" value="<?php echo htmlspecialchars($coupon['code']); ?>">
            <input type="number" name="quantity" class="form-control mt-3" required placeholder="Quantity" value="<?php echo htmlspecialchars($coupon['quantity']); ?>">
            <input type="number" name="discount" class="form-control mt-3" required placeholder="Discount Percentage" value="<?php echo htmlspecialchars($coupon['discount']); ?>">
            <input type="date" name="startDate" class="form-control mt-3" required placeholder="Start Date" value="<?php echo htmlspecialchars($coupon['startDate']); ?>">
            <input type="date" name="endDate" class="form-control mt-3" required placeholder="End Date" value="<?php echo htmlspecialchars($coupon['endDate']); ?>">
            <input type="submit" class="btn btn-success mt-3" value="Update">
            <?php if (isset($errors['name'])): ?>
                <br/>
                <span class='text-danger'><?php echo $errors['name']; ?></span>
            <?php endif; ?>
            <?php if (isset($errors['db'])): ?>
                <br/>
                <span class='text-danger'><?php echo $errors['db']; ?></span>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>
