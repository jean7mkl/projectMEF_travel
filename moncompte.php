<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connecter.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="stylesheet" href="sitedevoyage.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo-title">
                <a href="projet.html" class="logo-link">
                    <img src="Logo.png" alt="Logo Travel4all" class="logo">
                </a>
                <h1>WHERE2GO</h1>
            </div>
            
            <nav>
                <a href="projet.html" class="btn-nav">Notre Accueil</a>
                <a href="pagequizz.html" class="btn-nav">Découvrir notre concept</a>
                <a href="présprojet.html" class="btn-nav">Qui sommes-nous?</a>
            </nav>

            <div class="header-auth">
                <a href="moncompte.php" class="btn btn-primary">Client</a>
                <a href="deconnexion.php" class="btn btn-danger">Se déconnecter</a>
            </div>
        </div>
    </header>

    <h1>Bienvenue, <?php echo $_SESSION['utilisateur']['login']; ?> !</h1>

    <div class="account-buttons">
        <a href="mes_voyages.php" class="btn">Mes voyages</a>
        <a href="historique.php" class="btn">Historique</a>
        <a href="profil.php" class="btn">Mon profil</a>
        <a href="deconnexion.php" class="btn btn-danger">Se déconnecter</a>
    </div>
</body>
</html>
