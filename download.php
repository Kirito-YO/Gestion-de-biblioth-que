<?php
include 'db.php';
include 'navbar.php';
#session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$book_id = $_GET['id'];
// Assume the digital book file path is stored in the database
$book = $conn->query("SELECT * FROM books WHERE id = $book_id")->fetch_assoc();

if ($book && isset($book['pdf_path'])) {
    $file_path = $book['pdf_path'];
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    readfile($file_path);
    exit;
} else {
    echo "The digital file for this book is not available.";
}
?>
