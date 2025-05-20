<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panneau d'administration</title>
  <link rel="stylesheet" href="sitedevoyage.css">
</head>
<body>
  <h1>Gestion des utilisateurs</h1>

  <table>
    <thead>
      <tr><th>ID</th><th>Login</th><th>Email</th><th>Rôle</th><th>Action</th><th>Status</th></tr>
    </thead>
    <tbody id="user-table"></tbody>
  </table>

  <a href="deconnexion.php">Se déconnecter</a>

  <script src="js/admin.js"></script>
</body>
</html>
