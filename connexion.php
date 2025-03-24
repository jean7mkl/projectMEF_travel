<?php
session_start();
$fichier_utilisateurs = 'utilisateurs.json';

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Charger les utilisateurs
    if (file_exists($fichier_utilisateurs)) {
        $utilisateurs = json_decode(file_get_contents($fichier_utilisateurs), true) ?? [];
        
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur["informations"]["email"] === $email && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
                // Connexion réussie -> Stocker en session
                $_SESSION["login"] = $utilisateur["login"];
                $_SESSION["nom"] = $utilisateur["informations"]["nom"];
                
                // Rediriger vers l'accueil ou le compte
                header("Location: moncompte.php");
                exit();
            }
        }
    }

    // Si les identifiants sont incorrects
    echo "Identifiants incorrects.";
}
?>
