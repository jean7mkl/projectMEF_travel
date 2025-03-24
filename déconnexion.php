<?php
session_start();
session_destroy(); // Supprime toutes les données de session
header("Location: projet.html"); // Redirige vers l'accueil
exit();
?>
