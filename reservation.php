<?php
session_start();

// Vérifie que l'utilisateur est bien connecté
if (!isset($_SESSION['login']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connecter.php");
    exit();
}

$login = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];
$fichier = 'reservation.json';

// Récupération des données du formulaire
$depart = $_POST["depart"] ?? '';
$adulte = (int)($_POST["adulte"] ?? 1);
$enfant = (int)($_POST["enfant"] ?? 0);
$date_depart = $_POST["date_depart"] ?? '';
$date_retour = $_POST["date_retour"] ?? '';
$classe = $_POST["classe"] ?? 'eco';
$bagage = $_POST["bagage"] ?? 'cabine';
$assurance = isset($_POST["assurance"]);

// Calcul du prix simple
$prix_base = 500;
$prix = $prix_base + $adulte * 100 + $enfant * 50;
if ($assurance) {
    $prix += 60;
}

// Récupération de la destination
$destination = $_POST["destination"] ?? null;

if (!$destination && file_exists("choixutilisateurs.json")) {
    $choix = json_decode(file_get_contents("choixutilisateurs.json"), true);
    if (isset($choix[$login]["choix"]) && is_array($choix[$login]["choix"])) {
        $dernier = end($choix[$login]["choix"]);
        $destination = ucfirst($dernier);
    }
}

if (!$destination) {
    $destination = "Destination inconnue";
}

// Création de la réservation
$reservation = [
    "login" => $login,
    "id_utilisateur" => $id_utilisateur,
    "date" => date("Y-m-d H:i:s"),
    "depart" => $depart,
    "adulte" => $adulte,
    "enfant" => $enfant,
    "date_depart" => $date_depart,
    "date_retour" => $date_retour,
    "classe" => $classe,
    "bagage" => $bagage,
    "assurance" => $assurance,
    "destination" => $destination,
    "prix" => $prix,
    "statut" => "En attente"
];

// Enregistrement dans le fichier JSON
$reservations = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];
$reservations[] = $reservation;
file_put_contents($fichier, json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

// Redirection vers la page de paiement
header("Location: paiement.php");
exit();
