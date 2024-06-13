<?php
include 'User.php';

$user = new User();
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Get the user ID from the form submission
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'role' => $_POST['role'],
        'status' => $_POST['status'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone']
    ];

    try {
        $user->updateUser($id, $data);
        header("Location: index.php");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
} else {
    $id = $_GET['id']; 
    $currentUser = $user->listUsers("SELECT * FROM users WHERE id = $id")[0];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h1>Edit User</h1>
    <?php if ($error) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($currentUser['id']); ?>">
        <label for="username">Username:</label><br>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($currentUser['username']); ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>"><br>
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label><br>
            <select class="form-select" id="role" name="role">
                <option value="user" <?php if ($currentUser['role'] === '0') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($currentUser['role'] === '1') echo 'selected'; ?>>Admin</option>
            </select>
        </div>
        <label for="status">Status:</label><br>
        <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($currentUser['status']); ?>"><br>
        <label for="address">Address:</label><br>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($currentUser['address']); ?>"><br>
        <label for="phone">Phone:</label><br>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($currentUser['phone']); ?>" required><br><br>
        <input type="submit" class="btn btn-primary" value="Update User">
    </form>
    <a href="index.php" class="btn btn-secondary">Back to List</a>
</body>
</html>
