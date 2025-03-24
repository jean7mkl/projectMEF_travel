<?php

// Activer l'affichage des erreurs (pour debug uniquement, à désactiver en prod)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Définir le fichier JSON
$fichier_utilisateurs = 'utilisateurs.json';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérification des champs (évite les erreurs si un champ est manquant)
    if (empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["sexe"]) || 
        empty($_POST["email"]) || empty($_POST["telephone"]) || empty($_POST["mot_de_passe"])) {
        die("Erreur : Tous les champs sont requis.");
    }

    // Récupérer et nettoyer les données du formulaire
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $sexe = $_POST["sexe"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $telephone = trim($_POST["telephone"]);
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT); // Hachage du mot de passe

    // Générer un login unique (ex: prenom.nom)
    $login = strtolower($prenom . '.' . $nom);

    // Charger les utilisateurs existants
    $utilisateurs = [];
    if (file_exists($fichier_utilisateurs)) {
        $contenu = file_get_contents($fichier_utilisateurs);
        $utilisateurs = json_decode($contenu, true) ?? [];
    }

    // Vérifier si l'email est déjà utilisé
    foreach ($utilisateurs as $user) {
        if ($user['informations']['email'] === $email) {
            die("Erreur : Cet email est déjà utilisé.");
        }
    }

    // Déterminer le nouvel ID (dernier ID + 1)
    $nouvel_id = count($utilisateurs) > 0 ? end($utilisateurs)["id"] + 1 : 1;

    // Créer un nouvel utilisateur
    $nouvel_utilisateur = [
        "id" => $nouvel_id,
        "login" => $login,
        "mot_de_passe" => $mot_de_passe,
        "role" => "utilisateur",
        "informations" => [
            "nom" => $nom . " " . $prenom,
            "email" => $email,
            "telephone" => $telephone
        ],
        "voyages" => [
            "consultes" => [],
            "achetes" => []
        ]
    ];

    // Ajouter l'utilisateur au tableau
    $utilisateurs[] = $nouvel_utilisateur;

    // Sauvegarder dans le fichier JSON
    if (file_put_contents($fichier_utilisateurs, json_encode($utilisateurs, JSON_PRETTY_PRINT))) {
        // Redirection après inscription réussie
        header("Location: connecter.html");
        exit();
    } else {
        die("Erreur : Impossible d'écrire dans le fichier JSON.");
    }
}

?>
