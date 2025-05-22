<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['login'], $_SESSION['id_utilisateur'])) {
    header('Location: connecter.php'); exit;
}

$login = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];
$fichier = 'reservation.json';

// Récupération des données du formulaire
$depart        = $_POST['depart']       ?? '';
$adulte        = (int)($_POST['adulte'] ?? 1);
$enfant        = (int)($_POST['enfant'] ?? 0);
$date_depart   = $_POST['date_depart']  ?? date('Y-m-d');
$date_retour   = $_POST['date_retour']  ?? date('Y-m-d');
$classe        = $_POST['classe']      ?? 'eco';
$bagage        = $_POST['bagage']      ?? 'cabine';
$assurance     = isset($_POST['assurance']);
$destination   = $_POST['destination']  ?? 'Destination inconnue';

// Calcul du prix
$prix_base = 500;
$prix = $prix_base + $adulte * 100 + $enfant * 50 + ($assurance ? 60 : 0);

// Génération et stockage de l'ID de transaction
$transaction = uniqid();

// Préparation de la réservation
$reservation = [
    'login'                => $login,
    'id_utilisateur'       => $id_utilisateur,
    'date'                 => date('Y-m-d H:i:s'),
    'depart'               => $depart,
    'adulte'               => $adulte,
    'enfant'               => $enfant,
    'date_depart'          => $date_depart,
    'date_retour'          => $date_retour,
    'classe'               => $classe,
    'bagage'               => $bagage,
    'assurance'            => $assurance,
    'destination'          => $destination,
    'prix'                 => $prix,
    'status'               => 'En attente',
    'transaction'          => $transaction
];

// Lecture puis enregistrement
$reservations = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];
$reservations[] = $reservation;
$id_reservation = count($reservations) - 1;
file_put_contents(
    $fichier,
    json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
);

// Auto-redirection vers paiement
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Redirection Paiement</title></head>
<body>
<?php include 'header.php'; ?>
<main style="text-align:center; padding:50px;">
  <p>Merci ! Votre réservation a été créée.</p>
  <p>Redirection vers le paiement...</p>
  <form id="autoPay" action="paiement.php" method="POST">
    <input type="hidden" name="id_reservation" value="<?= $id_reservation ?>">
    <input type="hidden" name="destination"    value="<?= htmlspecialchars($destination, ENT_QUOTES) ?>">
    <input type="hidden" name="montant"        value="<?= $prix ?>">
    <input type="hidden" name="transaction"    value="<?= htmlspecialchars($transaction, ENT_QUOTES) ?>">
  </form>
  <script>document.getElementById('autoPay').submit();</script>
</main>
<?php include 'footer.php'; ?>
</body>
</html>