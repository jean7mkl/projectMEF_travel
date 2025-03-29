<?php
session_start();
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
    <link rel="stylesheet" href="sitedevoyage.css"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel4all</title>
    
</head>
<body>
    <style>.alert-success {
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
            </nav>
            <div class="header-auth">
    <?php if ($username): ?>
        <a href="moncompte.php" class="btn btn-primary"><?php echo htmlspecialchars($username); ?></a>
        <a href="deconnexion.php" class="btn btn-primary">Se déconnecter</a>
    <?php else: ?>
        <a href="connexion.php" class="btn btn-primary">Connexion</a>
        <a href="inscription.php" class="btn btn-secondary">Inscription</a>
    <?php endif; ?>
</div>

        </div>
    </header>
    <div class="hero">1~Découvrez notre concept futuriste !
    <div class="subtitle"><br/><br/><br/><br/>2~On vous trouve le voyage dont vous avez tant révés !</div></div>
    <p>
    <center>
    <div class="container">
        <!-- Section du Quiz -->
        <div class="offers">
            <div class="offer"><img src="https://www.fodors.com/wp-content/uploads/2019/01/Maldives2.gif" alt="Maldives">
                <h2 id="Nos-offres">NOTRE QUIZ</h2>
                <a href="pagequizz.php" class="lienquiz">Démarrer le Quiz</a>
            </div>
        </div>

    </div>
</center>
</p>
    <footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
    </footer>
</body>
</html>
