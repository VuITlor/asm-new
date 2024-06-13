<?php
include_once('./DBUtil.php');

$dbHelper = new DBUntil();
$type = $_GET['type'];
$id = $_GET['id'];

if ($type == 'category') {
    $dbHelper->delete('categories', "id=$id");
} elseif ($type == 'product') {
    $dbHelper->delete('products', "id=$id");
}

header("Location: index.php");
exit();
?>