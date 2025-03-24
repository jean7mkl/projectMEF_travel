<?php
require('getapikey.php'); // Assurez-vous d'avoir téléchargé ce fichier

// Données de la transaction
$transaction = uniqid(); // Génère un identifiant unique pour chaque transaction
$montant = "18000.99"; // Montant avec 2 chiffres après la virgule
$vendeur = "MI-1_A"; // Remplacez par votre code vendeur
$retour = "http://localhost/retour_paiement.php"; // URL de retour après le paiement

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
    <title>Interface de Paiement</title>
</head>
<body>
    <h2>Effectuer un Paiement</h2>
    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?= $transaction ?>">
        <input type="hidden" name="montant" value="<?= $montant ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
        <input type="hidden" name="retour" value="<?= $retour ?>">
        <input type="hidden" name="control" value="<?= $control ?>">
        <input type="submit" value="Payer maintenant">
    </form>
</body>
</html>
