<?php
session_start();



$username = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];

$reservations_utilisateur = [];

$json = file_get_contents("reservation.json");
$all_reservations = json_decode($json, true);

// On garde seulement les réservations de l'utilisateur connecté
foreach ($all_reservations as $reservation) {
    if ($reservation['id_utilisateur'] == $id_utilisateur) {
        $reservations_utilisateur[] = $reservation;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Voyages</title>
    <link rel="stylesheet" href="sitedevoyage.css">
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo-title">
            <a href="projet.php" class="logo-link">
                <img src="photo/Logo.png" alt="Logo Travel4all" class="logo">
            </a>
            <h1>WHERE2GO</h1>
        </div>

        <nav>
            <a href="projet.php" class="btn-nav">Accueil</a>
            <a href="pagequizz.php" class="btn-nav">Notre concept</a>
            <a href="présprojet.php" class="btn-nav">Qui sommes-nous?</a>
        </nav>

        <div class="header-auth">
            <a href="moncompte.php" class="btn btn-primary"><?php echo $username; ?></a>
            <a href="déconnexion.php" class="btn btn-primary">Se déconnecter</a>
        </div>
    </div>
</header>
<main class="compte2-section">
    <h1>Mes voyages</h1>

    <?php if (empty($reservations_utilisateur)): ?>
        <p>Vous n’avez encore réservé aucun voyage.</p>
    <?php else: ?>
        <div class="voyages-list">
            <?php foreach ($reservations_utilisateur as $voyage): ?>
                <div class="voyage-card">
                    <h3><?php echo htmlspecialchars($voyage['destination']); ?></h3>
                    <p><strong>Départ :</strong> <?php echo htmlspecialchars($voyage['date_depart']); ?></p>
                    <p><strong>Retour :</strong> <?php echo htmlspecialchars($voyage['date_retour']); ?></p>
                    <p><strong>Prix :</strong> <?php echo htmlspecialchars($voyage['prix']); ?> €</p>
                    <p><strong>Statut :</strong> <?php echo htmlspecialchars($voyage['statut']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>


<footer>
    <p>&copy; 2025 Agence de Voyage de Léo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
</footer>

</body>
</html>
