<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/utils.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$error = '';
$title = '';
$author = '';
$genre = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
csrf_check($_POST['csrf_token'] ?? null);

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$genre = trim($_POST['genre'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($title === '' || $author === '') {
$error = "Le titre et l'auteur sont obligatoires.";
} else {
try {
$slug = make_slug($title);

$check = $pdo->prepare("SELECT id FROM books WHERE slug = :slug LIMIT 1");
$check->execute(['slug' => $slug]);
if ($check->fetch()) {
$slug = $slug . '-' . bin2hex(random_bytes(2));
}

$stmt = $pdo->prepare("INSERT INTO books (title, author, genre, description, slug, created_at) VALUES (:title, :author, :genre, :description, :slug, NOW())");
$stmt->execute([
'title' => $title,
'author' => $author,
'genre' => $genre,
'description' => $description,
'slug' => $slug
]);

header('Location: /lilbook/admin/dashboard.php?success=created');
exit;
} catch (PDOException $e) {
$error = "Erreur lors de l'ajout : " . $e->getMessage();
}
}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ajouter un livre - LilBook</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
<h1> Ajouter un livre</h1>

<div style="margin-bottom: 16px;">
<a href="dashboard.php">← Retour au dashboard</a>
</div>

<?php if ($error): ?>
<div class="error" style="margin-bottom: 16px;">
<?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
</div>
<?php endif; ?>

<form method="POST" action="">
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">

<div class="form-group">
<label for="title">Titre * :</label>
<input type="text" id="title" name="title" required value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>">
</div>

<div class="form-group">
<label for="author">Auteur * :</label>
<input type="text" id="author" name="author" required value="<?= htmlspecialchars($author, ENT_QUOTES, 'UTF-8') ?>">
</div>

<div class="form-group">
<label for="genre">Genre :</label>
<input type="text" id="genre" name="genre" value="<?= htmlspecialchars($genre, ENT_QUOTES, 'UTF-8') ?>">
</div>

<div class="form-group">
<label for="description">Description :</label>
<textarea id="description" name="description" rows="5"><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></textarea>
</div>

<button type="submit">Ajouter</button>
</form>
</div>
</body>
</html>