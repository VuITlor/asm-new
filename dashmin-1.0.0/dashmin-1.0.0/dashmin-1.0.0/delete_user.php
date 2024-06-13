<?php
include 'user.php';

$user = new User();
$user->deleteUser($_GET['id']);
header("Location: list_user.php");
?>
