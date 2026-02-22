<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function isAdmin(): bool
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: /lilbook/login.php');
        exit;
    }
}