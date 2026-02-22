<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - LilBook</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
<h1> Panneau d'administration</h1>

<nav>
<a href="/lilbook/index.php">← Accueil</a>
<a href="/lilbook/admin/create.php"> Ajouter un livre</a>
<a href="/lilbook/logout.php">Déconnexion</a>
</nav>

<?php if (!empty($_GET['success']) && $_GET['success'] === 'created'): ?>
<div class="success">Livre ajouté avec succès.</div>
<?php endif; ?>
<?php if (!empty($_GET['success']) && $_GET['success'] === 'updated'): ?>
<div class="success">Livre modifié avec succès.</div>
<?php endif; ?>
<?php if (!empty($_GET['success']) && $_GET['success'] === 'deleted'): ?>
<div class="success">Livre supprimé.</div>
<?php endif; ?>

<h2>Gestion des livres</h2>

<?php if (empty($books)): ?>
<p>Aucun livre pour le moment.</p>
<?php else: ?>
<table style="width: 100%; border-collapse: collapse;">
<thead>
<tr style="background: #f2f2f2;">
<th style="padding: 10px; text-align: left;">Titre</th>
<th style="padding: 10px; text-align: left;">Auteur</th>
<th style="padding: 10px; text-align: left;">Genre</th>
<th style="padding: 10px; text-align: left;">Slug</th>
<th style="padding: 10px; text-align: left;">Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($books as $book): ?>
<tr style="border-bottom: 1px solid #ddd;">
<td style="padding: 10px;"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></td>
<td style="padding: 10px;"><?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?></td>
<td style="padding: 10px;"><?= htmlspecialchars($book['genre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
<td style="padding: 10px;"><?= htmlspecialchars($book['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
<td style="padding: 10px;">
<a href="/lilbook/admin/edit.php?s=<?= urlencode($book['slug']) ?>"> Modifier</a>
<form method="POST" action="/lilbook/admin/delete.php" style="display:inline;">
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
<input type="hidden" name="slug" value="<?= htmlspecialchars($book['slug'], ENT_QUOTES, 'UTF-8') ?>">
<button type="submit" onclick="return confirm('Supprimer ?')"> Supprimer</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
</div>
</body>
</html>