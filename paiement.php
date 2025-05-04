<?php
session_start();
require('getapikey.php');

// Vérifier que les données POST sont présentes
if (!isset($_POST['montant'], $_POST['destination'], $_POST['id_reservation'])) {
    die("Erreur : données manquantes pour le paiement.");
}

$montant = number_format((float)$_POST['montant'], 2, '.', '');
$destination = htmlspecialchars($_POST['destination']);
$id_reservation = (int)$_POST['id_reservation'];

$transaction = uniqid();
$vendeur = "MEF-1_E";
$retour = "http://localhost:8080/jalon2/confirmation_paiement.php?id_reservation=" . $id_reservation;


// Récupération de la clé API
$api_key = getAPIKey($vendeur);

if (!preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    die("Erreur : API Key invalide !");
}

// Génération du hash de sécurité
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement du voyage</title>
    <link rel="stylesheet" href="sitedevoyage.css">
</head>
<body>
<?php include 'header.php'; ?>

<center>
    <br><br><br><br>
    <h2 class="paiement">Paiement pour : <?= $destination ?> — <?= $montant ?> €</h2>

    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?= $transaction ?>">
        <input type="hidden" name="montant" value="<?= $montant ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
        <input type="hidden" name="retour" value="<?= $retour ?>">
        <input type="hidden" name="control" value="<?= $control ?>">
        <input type="submit" class="btn btn-primary" value="Payer maintenant">
    </form>
    <br><br><br><br>
</center>

<?php include 'footer.php'; ?>
</body>
</html>
