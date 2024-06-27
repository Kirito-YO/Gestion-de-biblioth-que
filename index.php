<?php
include 'db.php';
include 'navbar.php';

$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="icon" href="images/favicon.png" type="image/png">
    <title>Library Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Welcome to the Library</h1>
        <div class="row">
            <?php while ($book = $books->fetch_assoc()) { ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body bg">
                        <h3 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p class="card-text">Author: <?php echo htmlspecialchars($book['author']); ?></p>
                        <p class="card-text">Published Year: <?php echo htmlspecialchars($book['published_year']); ?></p>
                        <p class="card-text">Stock: <?php echo htmlspecialchars($book['stock']); ?></p>
                        <a href="details.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="btn btn-primary">View Details</a>
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <a href="borrow.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="btn btn-success">Borrow</a>
                            <?php if ($book['pdf_path']) { ?>
                                <a href="<?php echo htmlspecialchars($book['pdf_path']); ?>" class="btn btn-info">Download</a>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="login.php" class="btn btn-success">Borrow</a>
                            <?php if ($book['pdf_path']) { ?>
                                <a href="login.php" class="btn btn-info">Download</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>