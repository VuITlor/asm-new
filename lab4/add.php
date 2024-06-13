<?php
include 'User.php';

$user = new User();
$error = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (!isset($_POST['username']) || empty(trim($_POST['username']))) {
        $error['username'] = "Username cannot be empty!";
    }
    if (!isset($_POST['password']) || empty(trim($_POST['password']))) {
        $error['password'] = "Password cannot be empty!";
    }
    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email address!";
    }
    if (!isset($_POST['phone']) || empty(trim($_POST['phone']))) {
        $error['phone'] = "Phone number cannot be empty!";
    }

    if (empty($error)) {
        $status = isset($_POST['status']) ? 1 : 0;
        $data = [
            'username' => htmlspecialchars(trim($_POST['username'])),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'email' => htmlspecialchars(trim($_POST['email'])),
            'role' => (int)$_POST['role'],
            'status' => $status,
            'address' => htmlspecialchars(trim($_POST['address'])),
            'phone' => htmlspecialchars(trim($_POST['phone']))
        ];

        try {
            $user->addUser($data);
            header("Location: index.php");
            exit(); 
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add user</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h1 class="text-center">Add New User</h1>
    <div class="container">
        <?php if (is_array($error)) : ?>
        <?php elseif ($error) : ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
                <?php if (isset($error['username'])): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($error['username']); ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <?php if (isset($error['password'])): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($error['password']); ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
                <?php if (isset($error['email'])): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($error['email']); ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="status" name="status">
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <?php if (isset($error['phone'])): ?>
                    <div class="text-danger"><?php echo htmlspecialchars($error['phone']); ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</body>
</html>
