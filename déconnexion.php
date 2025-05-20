<?php
session_start();
session_unset();            // On vide la session
session_destroy();          // On détruit la session

// Nouvelle session juste pour le message flash
session_start();
$_SESSION['message'] = "Vous avez bien été déconnecté.";

header("Location: projet.php"); // Redirection vers l'accueil
exit();
?>
