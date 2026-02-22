<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$slug = $_GET['s'] ?? '';
$slug = trim($slug);

if ($slug === '') {
http_response_code(400);
exit("Slug manquant dans l'URL (edit.php?s=...)");
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE slug = :slug LIMIT 1');
$stmt->execute(['slug' => $slug]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
http_response_code(404);
exit("Aucun livre trouvé pour ce slug : " . htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
csrf_check($_POST['csrf_token'] ?? null);

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$genre = trim($_POST['genre'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($title === '' || $author === '') {
$error = "Le titre et l'auteur sont obligatoires";
} else {
$stmt = $pdo->prepare('UPDATE books SET title = :title, author = :author, genre = :genre, description = :description WHERE slug = :slug');
$stmt->execute([
'title' => $title,
'author' => $author,
'genre' => $genre,
'description' => $description,
'slug' => $slug
]);
header('Location: /lilbook/admin/dashboard.php?success=updated');
exit;
}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier un livre - LilBook</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
<h1> Modifier un livre</h1>

<nav>
<a href="/lilbook/admin/dashboard.php">← Retour au dashboard</a>
</nav>

<?php if ($error): ?>
<div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form method="POST" action="">
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">

<div class="form-group">
<label for="title">Titre * :</label>
<input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>" required>
</div>

<div class="form-group">
<label for="author">Auteur * :</label>
<input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?>" required>
</div>

<div class="form-group">
<label for="genre">Genre :</label>
<input type="text" id="genre" name="genre" value="<?= htmlspecialchars($book['genre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
</div>

<div class="form-group">
<label for="description">Description :</label>
<textarea id="description" name="description" rows="5"><?= htmlspecialchars($book['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
</div>

<button type="submit">Modifier le livre</button>
</form>
</div>
</body>
</html>