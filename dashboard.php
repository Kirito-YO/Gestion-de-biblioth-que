<?php
include 'db.php';
include 'navbar.php';
#session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Library Dashboard</h2>
        <nav>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="books.php">Books</a></li>
                <?php if ($role == 'admin') { ?>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link" href="borrow.php">Borrow</a></li>
                <li class="nav-item"><a class="nav-link" href="sales.php">Sales</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
