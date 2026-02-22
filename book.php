<?php
require_once __DIR__ . '/includes/db.php';

$slug = $_GET['s'] ?? null;
if (!$slug) {
http_response_code(404);
exit('Livre introuvable');
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE slug = :slug LIMIT 1");
$stmt->execute(['slug' => $slug]);
$book = $stmt->fetch();

if (!$book) {
http_response_code(404);
exit('Livre introuvable');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></title>
<link rel="stylesheet" href="/lilbook/assets/style.css">
</head>
<body>
<div class="container">
<a href="/lilbook/index.php">← Retour</a>
<h1><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></h1>
<p><strong>Auteur:</strong> <?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?></p>
<p><strong>Genre:</strong> <?= htmlspecialchars($book['genre'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
<p><?= nl2br(htmlspecialchars($book['description'] ?? '', ENT_QUOTES, 'UTF-8')) ?></p>
</div>
</body>
</html>