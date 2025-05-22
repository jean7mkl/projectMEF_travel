
<?php
session_start();

// 1. Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login']) || !isset($_SESSION['id_utilisateur'])) {
    $_SESSION['message'] = "Vous devez être connecté pour ajouter un voyage au panier.";
    header("Location: connecter.php");
    exit();
}

// 2. Vérifier si les informations nécessaires sont passées en GET
if (!isset($_GET['slug']) || !isset($_GET['nom']) || !isset($_GET['prix_base_catalogue'])) {
    $_SESSION['message'] = "Informations manquantes pour ajouter le voyage au panier.";
    header("Location: voyage.php"); // Rediriger vers le catalogue
    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$login = $_SESSION['login'];
$destination_nom = htmlspecialchars($_GET['nom']);
$prix_base_catalogue = (float)$_GET['prix_base_catalogue']; // Prix de base venant du catalogue

// 3. Créer l'objet de réservation avec des valeurs par défaut
//    Ces valeurs pourront être modifiées plus tard par l'utilisateur
//    via un formulaire d'édition ou en complétant le formulaire de réservation.

// Calcul du prix initial (peut être affiné ou modifié par l'utilisateur plus tard)
$adulte_defaut = 1;
$enfant_defaut = 0;
$assurance_defaut = false;
$prix_calcule = $prix_base_catalogue + ($adulte_defaut * 100) + ($enfant_defaut * 50);
if ($assurance_defaut) {
    $prix_calcule += 60;
}

$nouvelle_reservation = [
    "id_reservation" => time() . "_" . uniqid(), // ID unique plus robuste
    "id_utilisateur" => $id_utilisateur,
    "login" => $login,
    "destination" => $destination_nom,
    "date_depart" => "", // À définir par l'utilisateur
    "date_retour" => "", // À définir par l'utilisateur
    "depart" => "", // Aéroport de départ, à définir
    "adulte" => $adulte_defaut,
    "enfant" => $enfant_defaut,
    "classe" => "eco", // Valeur par défaut
    "bagage" => "cabine", // Valeur par défaut
    "assurance" => $assurance_defaut,
    "prix" => $prix_calcule, // Prix initial basé sur 1 adulte, 0 enfant, sans assurance
    "statut" => "En attente", // Ou "Dans le panier" si vous voulez un statut spécifique
    "date_ajout_panier" => date("Y-m-d H:i:s")
];

// 4. Lire le fichier reservation.json, ajouter la nouvelle réservation, et sauvegarder
$fichier_reservations = 'reservation.json';
$reservations = [];

if (file_exists($fichier_reservations)) {
    $contenu = file_get_contents($fichier_reservations);
    $reservations = json_decode($contenu, true);
    // S'assurer que $reservations est un tableau même si le fichier est vide ou corrompu
    if (!is_array($reservations)) {
        $reservations = [];
    }
}

$reservations[] = $nouvelle_reservation;

if (file_put_contents($fichier_reservations, json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX)) {
    $_SESSION['message'] = "Le voyage '".htmlspecialchars($destination_nom)."' a été ajouté à votre panier !";
} else {
    $_SESSION['message'] = "Erreur lors de l'ajout du voyage au panier.";
}

// 5. Rediriger vers la page de l'historique/panier
header("Location: historique.php");
exit();
?>  