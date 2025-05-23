<?php
session_start();
// On peut carrément détruire la session si on veut
// session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accès refusé</title>
  <link rel="stylesheet" href="sitedevoyage.css">
  <style>
    body { text-align:center; padding:100px; font-family:sans-serif; }
    h1 { color:#c00; }
    a { color:#0077cc; text-decoration:none; }
  </style>
</head>
<body>
  <h1>🔒 Accès refusé</h1>
  <p>Votre compte a été suspendu.<br>
     Si vous pensez qu’il s’agit d’une erreur, contactez l’administrateur : Romuald.Grignon@CY.fr</p>
  <p><a href="projet.php">← Retour à l’accueil</a></p>
</body>
</html>
