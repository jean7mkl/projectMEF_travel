<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Voyages</title>
    <link rel="stylesheet" href="sitedevoyage.css">
</head>
<body>

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
        </nav>

        <div class="header-auth">
            <?php if (isset($_SESSION['login'])) : ?>
                <!-- Bouton "Client" -->
                <a href="moncompte.php" class="btn btn-primary"><?php echo $username; ?></a>
                <a href="déconnexion.php" class="btn btn-primary">Se déconnecter</a>
            <?php else : ?>
                <!-- Boutons pour les non-connectés -->
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            <?php endif; ?>
        </div>
    </div>
</header>
