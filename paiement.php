<?php
session_start();
require('getapikey.php'); // Assurez-vous d'avoir téléchargé ce fichier

// Données de la transaction
$transaction = uniqid(); // Génère un identifiant unique pour chaque transaction
$montant = "18000.99"; // Montant avec 2 chiffres après la virgule
$vendeur = "MEF-1_E"; // Remplacez par votre code vendeur
$retour = "http://localhost:8080/jalon2/historique.php"; // URL de retour après le paiement

// Récupération de l'API Key
$api_key = getAPIKey($vendeur);

// Vérification de la validité de l'API Key
if (!preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    die("Erreur : API Key invalide !");
}

// Génération de la valeur de contrôle (hash MD5)
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel=stylesheet href="sitedevoyage.css">
    <title>Interface de Paiement</title>
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
                <a href="moncompte.php" class="btn btn-primary"><?php echo htmlspecialchars($_SESSION["login"]); ?></a>
                <a href="déconnexion.php" class="btn btn-primary">Se déconnecter</a>
            <?php else : ?>
                <!-- Boutons pour les non-connectés -->
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            <?php endif; ?>
        </div>
        </div>
    </header><center></br></br></br></br></br></br>
    <h2 class="paiement">Effectuer un Paiement</h2>
    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?= $transaction ?>">
        <input type="hidden" name="montant" value="<?= $montant ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
        <input type="hidden" name="retour" value="<?= $retour ?>">
        <input type="hidden" name="control" value="<?= $control ?>">
        <input type="submit" value="Payer maintenant">
    </form></center></br></br></br></br></br></br>
    <footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p> 
    </footer>


</body>
</html>
