<?php
session_start();
include_once('./DBUtil.php');

$dbHelper = new DBUntil();

$product_errors = [];
$records_per_page = 4;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$offset = ($current_page - 1) * $records_per_page;
$search_query = isset($_GET['query']) ? $_GET['query'] : "";
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 0;

// Truy vấn lấy tất cả các danh mục
$categories_query = "SELECT * FROM categories";
$categories = $dbHelper->select($categories_query);

// Mẫu truy vấn để lấy sản phẩm theo từ khóa tìm kiếm, lọc theo danh mục và phạm vi giá
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          JOIN categories c ON p.category_id = c.id 
          WHERE p.name LIKE '%$search_query%'";

// Thêm điều kiện lọc theo danh mục nếu người dùng đã chọn danh mục
if ($category_filter > 0) {
    $query .= " AND p.category_id = $category_filter";
}

// Tiếp tục thêm điều kiện lọc theo phạm vi giá
if ($min_price > 0 && $max_price > 0) {
    $query .= " AND p.price BETWEEN $min_price AND $max_price";
} elseif ($min_price == 0 && $max_price > 0) {
    $query .= " AND p.price < $max_price";
} elseif ($min_price > 0 && $max_price == 0) {
    $query .= " AND p.price >  $min_price";
}
// Giới hạn số lượng sản phẩm và số trang hiển thị
$query .= " LIMIT $offset, $records_per_page";
$products = $dbHelper->select($query);

// Xây dựng truy vấn để tính tổng số sản phẩm phù hợp
$total_products_query = "SELECT COUNT(*) as total FROM products WHERE name LIKE '%$search_query%'";
if ($category_filter > 0) {
    $total_products_query .= " AND category_id = $category_filter";
}
// Thực hiện truy vấn để lấy tổng số lượng sản phẩm đáp ứng điều kiện tìm kiếm
$total_products_result = $dbHelper->select($total_products_query);
$total_products = $total_products_result[0]['total'];

// Hiển thị truy vấn để kiểm tra, có thể bỏ qua dòng này khi triển khai thực tế
// echo '<pre>';
// print_r($products);
// echo '</pre>';
// Tính toán và cập nhật số trang
$total_pages = ceil($total_products / $records_per_page);
// die();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index_user.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></h6>
                        <span>User</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index_user.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Sản Phẩm</a>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index_cart.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Giỏ hàng</a>
                </div>
                <div class="navbar-nav w-100">
                    <a href="order.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Đơn hàng</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <?php if (isset($_SESSION['username'])) : ?>
                                <span class="d-none d-lg-inline-flex"> Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
                            <?php else : ?>
                                <span>Bạn vui lòng đăng nhập để sử dụng dịch vụ</span>
                                <a href="signin.php" class="d-block btn btn-primary w-100">Sign In</a>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Sale & Revenue Start -->
            <h1>Products</h1>
            <div class="row mb-4">
                <div class="col-md-3">

                    <form method="GET" action="index_user.php">
                        <input class="form-control me-2" type="text" name="query" placeholder="Search" value="<?php echo $search_query;  ?>">
                        <button type="submit" class="btn btn-primary bi bi-search"></button>
                        <div class="input-group mb-2">
                            <select name="category" class="form-control">
                                <option value="0">All Categories</option>

                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['id']; ?>" <?php if ($category_filter == $category['id']) echo 'selected'; ?>><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="input-group mb-2">

                            <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>">
                            <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <?php if ($product['image']) : ?>
                                <img src="<?php echo $product['image']; ?>" class="card-img-top h-50" alt="<?php echo $product['name']; ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text"><?php echo $product['description']; ?></p>
                                <p class="card-text"><strong>Price:</strong> <?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                                <a href="detail_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary bi bi-eye"> Product Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if ($i === $current_page) echo 'active'; ?>">
                            <a class="page-link" href="index_user.php?page=<?php echo $i; ?>&query=<?php echo $search_query; ?>&category=<?php echo $category_filter; ?>&min_price=<?php echo $min_price; ?>&max_price=<?php echo $max_price; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
</body>

</html>