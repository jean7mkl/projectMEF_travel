<?php
session_start();

// Vérification de l'authentification de l'administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: connecter.html");
    exit();
}

$fichier_utilisateurs = 'utilisateurs.json';
$utilisateurs = file_exists($fichier_utilisateurs) ? json_decode(file_get_contents($fichier_utilisateurs), true) : [];

// Gérer les actions (promouvoir VIP, bannir)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'], $_POST['id'])) {
    $id = (int) $_POST['id'];
    
    foreach ($utilisateurs as &$utilisateur) {
        if ($utilisateur['id'] === $id) {
            if ($_POST['action'] === 'vip') {
                $utilisateur['role'] = 'VIP';
            } elseif ($_POST['action'] === 'ban') {
                $utilisateur['role'] = 'Banni';
            }
        }
    }
    file_put_contents($fichier_utilisateurs, json_encode($utilisateurs, JSON_PRETTY_PRINT));
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Panneau d'Administration</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <tr>
                <td><?= $utilisateur['id'] ?></td>
                <td><?= htmlspecialchars($utilisateur['login']) ?></td>
                <td><?= htmlspecialchars($utilisateur['informations']['email']) ?></td>
                <td><?= $utilisateur['role'] ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">
                        <button type="submit" name="action" value="vip">Promouvoir VIP</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">
                        <button type="submit" name="action" value="ban">Bannir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="deconnexion.php">Se déconnecter</a>
</body>
</html>
