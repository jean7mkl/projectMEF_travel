<?php
session_start();

$fichier = 'utilisateurs.json';
$utilisateurs = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];
$message = "";

// Traitement des actions admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $user_id = (int) $_POST['user_id'];
    foreach ($utilisateurs as &$utilisateur) {
        if ($utilisateur['id'] === $user_id) {
            switch ($_POST['action']) {
                case 'vip':
                    $utilisateur['statut'] = 'vip';
                    $message = "Utilisateur #$user_id est maintenant VIP.";
                    break;
                case 'normal':
                    $utilisateur['statut'] = 'normal';
                    $message = "Utilisateur #$user_id est redevenu normal.";
                    break;
                case 'banni':
                    $utilisateur['statut'] = 'banni';
                    $message = "Utilisateur #$user_id a été banni.";
                    break;
            }
            break;
        }
    }
    file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord administrateur</title>
    <link rel="stylesheet" href="sitedevoyage.css">
    <style>
        .loading-text {
            font-style: italic;
            font-size: 0.9em;
            color: #888;
            margin-left: 10px;
        }
        button[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo-title">
            <a href="projet.php" class="logo-link">
                <img src="photo/Logo.png" alt="Logo Travel4all" class="logo">
            </a>
            <h1>WHERE2GO - Admin</h1>
        </div>
        <nav>
            <a href="moncompte.php" class="btn-nav">Retour au compte</a>
        </nav>
    </div>
</header>

<main class="compte2-section">
    <h1>Gestion des utilisateurs</h1>

    <?php if (!empty($message)): ?>
        <div class="alert-success"> <?php echo $message; ?> </div>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= $utilisateur['id']; ?></td>
                    <td><?= htmlspecialchars($utilisateur['login']); ?></td>
                    <td><?= htmlspecialchars($utilisateur['informations']['nom']); ?></td>
                    <td><?= htmlspecialchars($utilisateur['informations']['email']); ?></td>
                    <td><?= $utilisateur['statut'] ?? 'normal'; ?></td>
                    <td>
                        <form method="POST" class="admin-action-form" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $utilisateur['id']; ?>">
                            <button name="action" value="vip" class="action-btn">VIP</button>
                            <button name="action" value="normal" class="action-btn">Normal</button>
                            <button name="action" value="banni" class="action-btn">Bannir</button>
                            <span class="loading-text" style="display:none;">⚙️ Mise à jour...</span>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<footer>
    <p>&copy; 2025 WHERE2GO - Administration</p>
</footer>

<script>
document.querySelectorAll(".admin-action-form").forEach(form => {
    const buttons = form.querySelectorAll(".action-btn");
    const loader = form.querySelector(".loading-text");

    buttons.forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            buttons.forEach(b => b.disabled = true);
            loader.style.display = "inline";

            setTimeout(() => {
                form.submit();
            }, 2000); // 2 secondes
        });
    });
});
</script>

</body>
</html>
