<?php
include_once('./DBUtil.php');

$dbHelper = new DBUntil();
$type = $_GET['type'];
$id = $_GET['id'];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($type == 'category') {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors['name'] = "Tên danh mục không được để trống!";
        } else {
            $dbHelper->update('categories', ['name' => $_POST['name']], "id=$id");
            header("Location: index.php");
            exit();
        }
    } elseif ($type == 'product') {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors['name'] = "Tên sản phẩm không được để trống!";
        }
        if (!isset($_POST['price']) || empty($_POST['price'])) {
            $errors['price'] = "Giá sản phẩm không được để trống!";
        }
        if (!isset($_POST['category_id']) || empty($_POST['category_id'])) {
            $errors['category'] = "Danh mục sản phẩm không được để trống!";
        }

        if (empty($errors)) {
            $image = $_POST['current_image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = 'uploads/' . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $image);
            }

            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image' => $image,
                'category_id' => $_POST['category_id']
            ];

            $dbHelper->update('products', $data, "id=$id");
            header("Location: index.php");
            exit();
        }
    }
}

if ($type == 'category') {
    $category = $dbHelper->select("SELECT * FROM categories WHERE id=$id")[0];
} elseif ($type == 'product') {
    $product = $dbHelper->select("SELECT * FROM products WHERE id=$id")[0];
    $categories = $dbHelper->select("SELECT * FROM categories");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chỉnh sửa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-3">
    <h2>Chỉnh sửa <?php echo $type == 'category' ? 'danh mục' : 'sản phẩm'; ?></h2>
    <form action="edit.php?id=<?php echo $id; ?>&type=<?php echo $type; ?>" method="post" enctype="multipart/form-data">
        <?php if ($type == 'category'): ?>
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>">
                <?php if (isset($errors['name'])) echo "<span class='text-danger'>{$errors['name']}</span>"; ?>
            </div>
        <?php elseif ($type == 'product'): ?>
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
                <?php if (isset($errors['name'])) echo "<span class='text-danger'>{$errors['name']}</span>"; ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description"><?php echo $product['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
                <?php if (isset($errors['price'])) echo "<span class='text-danger'>{$errors['price']}</span>"; ?>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-control" id="category_id" name="category_id">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['category'])) echo "<span class='text-danger'>{$errors['category']}</span>"; ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="image" name="image">
                <input type="hidden" name="current_image" value="<?php echo $product['image']; ?>">
                <?php if ($product['image']) echo "<img src='{$product['image']}' width='50'>"; ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
</body>
</html>
