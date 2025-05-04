<?php
session_start();

if (!isset($_GET['id_reservation'])) {
    $_SESSION['message'] = "Erreur : identifiant de réservation manquant.";
    header("Location: historique.php");
    exit();
}

$id = (int)$_GET['id_reservation'];
$fichier = 'reservation.json';

if (!file_exists($fichier)) {
    $_SESSION['message'] = "Erreur : fichier de réservation introuvable.";
    header("Location: historique.php");
    exit();
}

$reservations = json_decode(file_get_contents($fichier), true);

// Vérifie et met à jour la réservation
if (isset($reservations[$id])) {
    $reservations[$id]['statut'] = "Payée";
    file_put_contents($fichier, json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    $_SESSION['message'] = "Paiement confirmé pour " . htmlspecialchars($reservations[$id]['destination']) . ".";
} else {
    $_SESSION['message'] = "Réservation non trouvée.";
}

header("Location: historique.php");
exit();
