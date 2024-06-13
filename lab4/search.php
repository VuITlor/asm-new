<?php
include 'User.php';

$user = new User();
$query = $_GET['query'];
$results = $user->searchUsers($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Search user</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="mt-4 p-5 bg-primary text-white rounded">
            <h1 class ="mb-4">Search Results</h1>
            <a href="index.php" class="btn btn-primary">Back to List</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>

        </div>
    </div>
        <?php foreach ($results as $user) : ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo htmlspecialchars($user['status']); ?></td>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>