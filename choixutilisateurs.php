<?php
session_start();

header("Content-Type: application/json");

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["login"])) {
    die(json_encode(["error" => "Utilisateur non connecté."]));
}

// Définir le fichier JSON
$fichier_choix = "choixutilisateurs.json";

// Récupérer les données POST envoyées en JSON
$donnees = json_decode(file_get_contents("php://input"), true);

// Vérifier que les données sont valides
if (!$donnees || !isset($donnees["choix"])) {
    die(json_encode(["error" => "Aucune donnée reçue ou format incorrect."]));
}

// Vérification des permissions d'écriture
if (!is_writable($fichier_choix) && file_exists($fichier_choix)) {
    die(json_encode(["error" => "Permissions insuffisantes sur le fichier JSON."]));
}

// Récupérer les choix de l'utilisateur
$choix = $donnees["choix"];
$utilisateur = $_SESSION["login"];
$email = $_SESSION["email"] ?? "non spécifié";

// Lire le fichier existant ou créer un tableau vide
$choix_utilisateurs = [];
if (file_exists($fichier_choix)) {
    $contenu = file_get_contents($fichier_choix);
    $choix_utilisateurs = json_decode($contenu, true);

    // Vérification de la validité du JSON
    if ($choix_utilisateurs === null && json_last_error() !== JSON_ERROR_NONE) {
        die(json_encode(["error" => "Erreur de lecture du fichier JSON."]));
    }
}

// Ajouter ou mettre à jour les choix de l'utilisateur
$choix_utilisateurs[$utilisateur] = [
    "email" => $email, 
    "choix" => $choix,
    "date" => date("Y-m-d H:i:s")
];

// Écriture dans le fichier JSON
if (file_put_contents($fichier_choix, json_encode($choix_utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    die(json_encode(["success" => "Choix enregistrés !", "choix" => $choix]));
} else {
    die(json_encode(["error" => "Impossible d'écrire dans le fichier JSON."]));
}
?>
