<?php
session_start();
ob_start(); // Pour éviter les erreurs de redirection

include 'header.php';
include 'footer.php';

$fichiers_utilisateurs = ['utilisateurs.json', 'administrateur.json'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST["email"]));
    $mot_de_passe = $_POST["mot_de_passe"];

    if (empty($email) || empty($mot_de_passe)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header("Location: connecter.php?error=" . urlencode($_SESSION['error']));
        exit();
    }

    foreach ($fichiers_utilisateurs as $fichier) {
        if (file_exists($fichier)) {
            $utilisateurs = json_decode(file_get_contents($fichier), true);

            if (!is_array($utilisateurs)) continue;

            foreach ($utilisateurs as $utilisateur) {
                if (
                    isset($utilisateur["informations"]["email"], $utilisateur["mot_de_passe"]) &&
                    $utilisateur["informations"]["email"] === $email &&
                    password_verify($mot_de_passe, $utilisateur["mot_de_passe"])
                ) {
                    $_SESSION["login"] = $utilisateur["login"];
                    $_SESSION["nom"] = $utilisateur["informations"]["nom"];
                    $_SESSION["id_utilisateur"] = $utilisateur["id"];

                    if ($fichier === 'administrateur.json') {
                        $_SESSION["role"] = "admin";
                        header("Location: admin_dashboard.php");
                    } else {
                        $_SESSION["role"] = "utilisateur";
                        header("Location: moncompte.php");
                    }
                    exit();
                }
            }
        }
    }

    // ❌ Aucun utilisateur trouvé
    $_SESSION['error'] = "Email ou mot de passe incorrect.";
    header("Location: connecter.php?error=" . urlencode($_SESSION['error']));
    exit();
}

ob_end_flush();
?>
