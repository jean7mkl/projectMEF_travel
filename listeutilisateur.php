<?php
// Chemin vers le fichier utilisateurs.json
$fichier_utilisateurs = 'utilisateurs.json';

// Charger le contenu du fichier
$contenu = file_get_contents($fichier_utilisateurs);

// Décoder le JSON
$utilisateurs = json_decode($contenu, true);

// Vérifier s'il y a eu une erreur de décodage
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erreur de décodage JSON : " . json_last_error_msg());
}

// Afficher le nombre total d'utilisateurs
echo "Nombre total d'utilisateurs : " . count($utilisateurs) . "<br><br>";

// Afficher les détails de chaque utilisateur
foreach ($utilisateurs as $utilisateur) {
    echo "ID : " . $utilisateur['id'] . "<br>";
    echo "Login : " . $utilisateur['login'] . "<br>";
    echo "Nom : " . $utilisateur['informations']['nom'] . "<br>";
    echo "Email : " . $utilisateur['informations']['email'] . "<br>";
    echo "Téléphone : " . $utilisateur['informations']['telephone'] . "<br>";
    echo "Rôle : " . $utilisateur['role'] . "<br>";
    echo "<hr>";
}
?>