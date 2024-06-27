<?php
include 'db.php';
include 'navbar.php';

#session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sell'])) {
        $book_id = $_POST['book_id'];
        $quantity = $_POST['quantity'];
        $sale_date = $_POST['sale_date'];
        
        $sql = "INSERT INTO sales (book_id, quantity, sale_date) VALUES ($book_id, $quantity, '$sale_date')";
        $conn->query($sql);
        
        $sql = "UPDATE books SET stock = stock - $quantity WHERE id = $book_id";
        $conn->query($sql);
    }
}

$sales = $conn->query("SELECT sales.id, books.title, sales.quantity, sales.sale_date FROM sales JOIN books ON sales.book_id = books.id");
$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Sales</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Sales</h2>
        <form method="post" class="mb-3">
            <div class="form-group">
                <label for="book_id">Book</label>
                <select class="form-control" id="book_id" name="book_id" required>
                    <?php while ($book = $books->fetch_assoc()) { ?>
                    <option value="<?php echo $book['id']; ?>"><?php echo $book['title']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="sale_date">Sale Date</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" required>
            </div>
            <button type="submit" class="btn btn-primary" name="sell">Sell Book</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>Quantity</th>
                    <th>Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($sale = $sales->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $sale['id']; ?></td>
                    <td><?php echo $sale['title']; ?></td>
                    <td><?php echo $sale['quantity']; ?></td>
                    <td><?php echo $sale['sale_date']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
