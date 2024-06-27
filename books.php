<?php
include 'db.php';
include 'navbar.php';
#session_start();

// Vérifiez si l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Fonction pour gérer le téléchargement de fichiers PDF
function uploadPdf($file) {
    if (!empty($file['name'])) {
        $pdf_dir = 'uploads/';
        $pdf_file = $pdf_dir . basename($file['name']);
        $pdf_file_type = strtolower(pathinfo($pdf_file, PATHINFO_EXTENSION));

        // Vérifiez que le fichier est un PDF
        if ($pdf_file_type != "pdf") {
            die("Sorry, only PDF files are allowed.");
        }

        // Déplacez le fichier téléchargé dans le dossier des uploads
        if (move_uploaded_file($file['tmp_name'], $pdf_file)) {
            return $pdf_file;
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }
    return null;
}

// Traitement du formulaire pour ajouter ou mettre à jour un livre
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_year = $_POST['published_year'];
    $stock = $_POST['stock'];
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;

    // Téléchargez le fichier PDF si fourni
    $pdf_path = uploadPdf($_FILES['pdf']);

    if ($book_id) {
        // Mise à jour du livre existant
        if ($pdf_path) {
            $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, published_year = ?, stock = ?, pdf_path = ? WHERE id = ?");
            $stmt->bind_param("ssdisi", $title, $author, $published_year, $stock, $pdf_path, $book_id);
        } else {
            $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, published_year = ?, stock = ? WHERE id = ?");
            $stmt->bind_param("ssdii", $title, $author, $published_year, $stock, $book_id);
        }
    } else {
        // Ajout d'un nouveau livre
        $stmt = $conn->prepare("INSERT INTO books (title, author, published_year, stock, pdf_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $title, $author, $published_year, $stock, $pdf_path);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: books.php");
    exit;
}

// Récupérez la liste des livres
$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
	<link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Books</h2>

        <h3>Add / Update Book</h3>
        <form action="books.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="book_id" id="book_id">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="published_year">Published Year</label>
                <input type="number" class="form-control" id="published_year" name="published_year" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="pdf">Upload PDF</label>
                <input type="file" class="form-control" id="pdf" name="pdf">
            </div>
            <button type="submit" class="btn btn-primary">Save Book</button>
        </form>

        <h3 class="mt-5">Books List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Year</th>
                    <th>Stock</th>
                    <th>PDF</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($book = $books->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['published_year']); ?></td>
                    <td><?php echo htmlspecialchars($book['stock']); ?></td>
                    <td>
                        <?php if ($book['pdf_path']) { ?>
                            <a href="<?php echo htmlspecialchars($book['pdf_path']); ?>" class="btn btn-info" target="_blank">Download PDF</a>
                        <?php } ?>
                    </td>
                    <td>
                        <button class="btn btn-secondary" onclick="editBook(<?php echo htmlspecialchars(json_encode($book)); ?>)">Edit</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function editBook(book) {
            document.getElementById('book_id').value = book.id;
            document.getElementById('title').value = book.title;
            document.getElementById('author').value = book.author;
            document.getElementById('published_year').value = book.published_year;
            document.getElementById('stock').value = book.stock;
            document.getElementById('pdf').value = ''; // Clear file input
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>