<?php
include 'User.php';

$user = new User();
$user->deleteUser($_GET['id']);
header("Location: index.php");
?>
