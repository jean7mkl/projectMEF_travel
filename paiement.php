<?php
session_start();
require('getapikey.php');

// Validation POST
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['id_reservation'], $_POST['destination'], $_POST['montant'], $_POST['transaction'])
) {
    $_SESSION['message'] = 'Accès invalide.';
    header('Location: historique.php'); exit;
}

$id_reservation = (int)$_POST['id_reservation'];
$destination    = htmlspecialchars($_POST['destination'], ENT_QUOTES);
$montant        = number_format((float)$_POST['montant'], 2, '.', '');
$transaction    = $_POST['transaction'];
$vendeur        = 'MEF-1_E';

// URL de retour (utiliser HTTP en dev)
$retour = sprintf(
    'http://%s/jalon3/projectMEF_travel/retour_paiement.php?transaction=%s&id_reservation=%d',
    $_SERVER['HTTP_HOST'], rawurlencode($transaction), $id_reservation
);

// Calcul du contrôle
$api_key = getAPIKey($vendeur);
$control = md5(
    $api_key . "#{$transaction}#{$montant}#{$vendeur}#{$retour}#"
);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Paiement</title></head>
<body>
<?php include 'header.php'; ?>
<center>
  <h2>Paiement : <?= $destination ?> — <?= $montant ?> €</h2>
  <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
    <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction, ENT_QUOTES) ?>">
    <input type="hidden" name="montant"     value="<?= $montant ?>">
    <input type="hidden" name="vendeur"     value="<?= $vendeur ?>">
    <input type="hidden" name="retour"      value="<?= htmlspecialchars($retour, ENT_QUOTES) ?>">
    <input type="hidden" name="control"     value="<?= $control ?>">
    <input type="submit" class="btn btn-primary" value="Payer maintenant">
  </form>
</center>
<?php include 'footer.php'; ?>
</body>
</html>