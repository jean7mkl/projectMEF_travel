<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? null;

// Gestion du message flash
$message = $_SESSION['message'] ?? null;
if ($message) {
    unset($_SESSION['message']); // On le montre une seule fois
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <link id="theme-base" rel="stylesheet" href="sitedevoyage.css">
    <link id="theme-override" rel="stylesheet" href="">
   

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel4all</title>
    
</head>
<body>
 
<div class="mode-switch-container">
    <button id="toggle-theme" title="Changer le thème">🌙</button>
    <button id="toggle-contrast" title="Contraste">◼️</button>
    <button id="toggle-accessible" title="Accessibilité">👁️</button>
</div>

    <style>
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px 15px;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin: 15px auto;
        width: 90%;
        max-width: 600px;
        text-align: center;
    }
    </style>
    <?php if ($message): ?>
        <div class="alert-success">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <header>
        <div class="header-container">
            <div class="logo-title">
                <a href="projet.php" class="logo-link">
                    <img src="photo/Logo.png" alt="Logo Travel4all" class="logo">
                </a>
                <h1>WHERE2GO</h1>
            </div>
            <nav>
                <a href="projet.php" class="btn-nav">Notre Accueil</a>
                <a href="pagequizz.php" class="btn-nav">Découvrir notre concept</a>
                <a href="présprojet.php" class="btn-nav">Qui sommes-nous?</a>
                <a href="voyage.php" class="btn-nav">Notre catalogue</a>
            </nav>
            <div class="header-auth">
            <?php if (isset($_SESSION['login'])) : ?>
                <!-- Bouton "Client" -->
                <a href="moncompte.php" class="btn btn-primary"><?php echo htmlspecialchars($_SESSION["login"]); ?></a>
                <a href="déconnexion.php" class="btn btn-secondary">Se déconnecter</a>
            <?php else : ?>
                <!-- Boutons pour les non-connectés -->
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            <?php endif; ?>
            </div>
        
</div>
        

    </header>

