<?php
include 'db.php';
include 'navbar.php';
#session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['borrow'])) {
        $book_id = $_POST['book_id'];
        $user_id = $_POST['user_id'];
        $borrow_date = $_POST['borrow_date'];
        $return_date = $_POST['return_date'];
        
        $sql = "INSERT INTO borrow (book_id, user_id, borrow_date, return_date) VALUES ($book_id, $user_id, '$borrow_date', '$return_date')";
        $conn->query($sql);
    } elseif (isset($_POST['return'])) {
        $id = $_POST['id'];
        
        $sql = "DELETE FROM borrow WHERE id=$id";
        $conn->query($sql);
    }
}

$borrowed_books = $conn->query("SELECT borrow.id, books.title, users.username, borrow.borrow_date, borrow.return_date FROM borrow JOIN books ON borrow.book_id = books.id JOIN users ON borrow.user_id = users.id");
$books = $conn->query("SELECT * FROM books");
$students = $conn->query("SELECT * FROM users WHERE role='student'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Borrowed Books</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Borrowed Books</h2>
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
                <label for="user_id">User</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php while ($student = $students->fetch_assoc()) { ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['username']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="borrow_date">Borrow Date</label>
                <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
            </div>
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
            <button type="submit" class="btn btn-primary" name="borrow">Borrow Book</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>User</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($borrow = $borrowed_books->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $borrow['id']; ?></td>
                    <td><?php echo $borrow['title']; ?></td>
                    <td><?php echo $borrow['username']; ?></td>
                    <td><?php echo $borrow['borrow_date']; ?></td>
                    <td><?php echo $borrow['return_date']; ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $borrow['id']; ?>">
                            <button type="submit" name="return" class="btn btn-danger">Return Book</button>
                        </form>
                    </td>
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
