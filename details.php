<?php
include 'db.php';
include 'navbar.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$book_id = $_GET['id'];
$book = $conn->query("SELECT * FROM books WHERE id = $book_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
	<link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h1 class="mt-5"><?php echo $book['title']; ?></h1>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Author: <?php echo $book['author']; ?></h5>
                <p class="card-text">Published Year: <?php echo $book['published_year']; ?></p>
                <p class="card-text">Stock: <?php echo $book['stock']; ?></p>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="borrow.php?id=<?php echo $book['id']; ?>" class="btn btn-success">Borrow</a>
                    <a href="download.php?id=<?php echo $book['id']; ?>" class="btn btn-info">Download</a>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-success">Borrow</a>
                    <a href="login.php" class="btn btn-info">Download</a>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
