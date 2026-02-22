<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
header('Location: /lilbook/admin/dashboard.php');
exit;
}

csrf_check($_POST['csrf_token'] ?? null);

$slug = $_POST['slug'] ?? null;
if (!$slug) {
header('Location: /lilbook/admin/dashboard.php');
exit;
}

$stmt = $pdo->prepare('DELETE FROM books WHERE slug = :slug');
$stmt->execute(['slug' => $slug]);

header('Location: /lilbook/admin/dashboard.php?success=deleted');
exit;