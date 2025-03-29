<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            </div>
        </div>
    </header>
    <center> 
    <div class="container">
        <h2>Connexion Utilisateur</h2>
        <form action="connexion.php" method="POST">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="mot_de_passe" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="small-text">
                <a href="inscription.php">Mot de passe oublié?</a></br>
            </div></br>
            <button type="submit" class="btn"> Se connecter </button>
        </form>
    </div>
</center>
    <footer>
        <p>&copy; 2025 Agence de Voyage de Léo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
    </footer>
</body>
</html>
