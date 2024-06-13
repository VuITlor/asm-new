<?php
include_once('./DBUtil.php');

$dbHelper = new DBUntil();

$categories = $dbHelper->select("SELECT * FROM categories");
$products = $dbHelper->select("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");

$category_errors = [];
$product_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_category'])) {
        if (!isset($_POST['category_name']) || empty($_POST['category_name'])) {
            $category_errors['name'] = "Tên danh mục không được để trống!";
        } else {
            $isCreated = $dbHelper->insert('categories', ['name' => $_POST['category_name']]);
            if ($isCreated) {
                header("Location: index.php");
                exit();
            } else {
                $category_errors['general'] = "Lỗi khi tạo danh mục.";
            }
        }
    }

//add prouct
    if (isset($_POST['add_product'])) {
        if (!isset($_POST['product_name']) || empty($_POST['product_name'])) {
            $product_errors['name'] = "Tên sản phẩm không được để trống!";
        }
        if (!isset($_POST['product_price']) || empty($_POST['product_price'])) {
            $product_errors['price'] = "Giá sản phẩm không được để trống!";
        }
        if (!isset($_POST['product_category']) || empty($_POST['product_category'])) {
            $product_errors['category'] = "Danh mục sản phẩm không được để trống!";
        }

        if (empty($product_errors)) {
            $image = null;
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $image = $upload_dir . basename($_FILES["product_image"]["name"]);
                move_uploaded_file($_FILES["product_image"]["tmp_name"], $image);
            }

            $data = [
                'name' => $_POST['product_name'],
                'description' => $_POST['product_description'],
                'price' => $_POST['product_price'],
                'image' => $image,
                'category_id' => $_POST['product_category']
            ];
            
            $isCreated = $dbHelper->insert('products', $data);
            if ($isCreated) {
                header("Location: index.php");
                exit();
            } else {
                $product_errors['general'] = "Lỗi khi tạo sản phẩm.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quản lý sản phẩm và danh mục</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
    <h2>Quản lý danh mục</h2>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="category_name" class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" id="category_name" name="category_name">
            <?php if (isset($category_errors['name'])) echo "<span class='text-danger'>{$category_errors['name']}</span>"; ?>
            <?php if (isset($category_errors['general'])) echo "<span class='text-danger'>{$category_errors['general']}</span>"; ?>
        </div>
        <button type="submit" class="btn btn-success" name="add_category">Thêm danh mục</button>
    </form>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Acction</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?php echo $cat['id']; ?></td>
                    <td><?php echo $cat['name']; ?></td>
                    <td>
                        <a class="btn btn-danger" href="delete.php?id=<?php echo $cat['id']; ?>&type=category">Removve</a>
                        <a class="btn btn-primary" href="edit.php?id=<?php echo $cat['id']; ?>&type=category">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Add product</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="product_name" name="product_name">
            <?php if (isset($product_errors['name'])) echo "<span class='text-danger'>{$product_errors['name']}</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="product_description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="product_description" name="product_description"></textarea>
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Giá</label>
            <input type="text" class="form-control" id="product_price" name="product_price">
            <?php if (isset($product_errors['price'])) echo "<span class='text-danger'>{$product_errors['price']}</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="product_category" class="form-label">Categories</label>
            <select class="form-control" id="product_category" name="product_category">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($product_errors['category'])) echo "<span class='text-danger'>{$product_errors['category']}</span>"; ?>
        </div>
        <div class="mb-3">
            <label for="product_image" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="product_image" name="product_image">
        </div>
        <button type="submit" class="btn btn-primary" name="add_product">Update</button>
        <?php if (isset($product_errors['general'])) echo "<span class='text-danger'>{$product_errors['general']}</span>"; ?>
    </form>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Categories</th>
                <th>Acction</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php if ($product['image']) echo "<img src='{$product['image']}' width='50'>"; ?></td>
                    <td><?php echo $product['category_name']; ?></td>
                    <td>
                        <a class="btn btn-primary" href="edit.php?id=<?php echo $product['id']; ?>&type=product">Sửa</a>
                        <a class="btn btn-danger" href="delete.php?id=<?php echo $product['id']; ?>&type=product">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
