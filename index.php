<?php
session_start();
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=999">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LilBook - Votre bibliothèque en ligne</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
<div class="main-card">

<div class="header">
<h1>LilBook</h1>
<p>Votre bibliothèque personnelle en ligne</p>
</div>

<nav>
<?php if (isset($_SESSION['user_id'])): ?>
<span class="nav-pill">Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></strong></span>

<?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<a href="/lilbook/admin/dashboard.php">Administration</a>
<?php endif; ?>

<a href="/lilbook/logout.php">Déconnexion</a>

<?php else: ?>
<a href="/lilbook/login.php">Connexion</a>
<a href="/lilbook/register.php">Inscription</a>
<?php endif; ?>
</nav>

<h2>Nos livres</h2>

<?php if (empty($books)): ?>
<p>Aucun livre disponible pour le moment.</p>
<?php else: ?>
<div class="book-list">
<?php foreach ($books as $book): ?>
<div class="book-item">

<h3>
<a href="/lilbook/book.php?s=<?= urlencode($book['slug'] ?? '') ?>">
<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>
</a>
</h3>

<p><strong>Auteur :</strong> <?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?></p>

<?php if (!empty($book['genre'])): ?>
<p><strong>Genre :</strong> <?= htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<?php if (!empty($book['description'])): ?>
<p><em><?= nl2br(htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8')) ?></em></p>
<?php endif; ?>

<?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<div class="admin-actions">
</div>
<?php endif; ?>

</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

</div>
</div>

</body>
</html>