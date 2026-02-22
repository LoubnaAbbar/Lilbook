<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Veuillez remplir tous les champs';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit faire au moins 6 caractères';
    } else {
       
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        
        if ($stmt->fetch()) {
            $error = 'Ce nom d\'utilisateur est déjà pris';
        } else {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, "user")');
            
            if ($stmt->execute(['username' => $username, 'password' => $hashed_password])) {
                $success = 'Compte créé avec succès ! Tu peux maintenant te connecter.';
            } else {
                $error = 'Erreur lors de la création du compte';
            }
        }
    }
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
    <title>Inscription - LilBook</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
        <h1> Inscription à LilBook</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">S'inscrire</button>
        </form>
        
        <p>Déjà un compte ? <a href="login.php">Connecte-toi ici</a></p>
        <p><a href="index.php">← Retour à l'accueil</a></p>
    </div>
</body>
</html>