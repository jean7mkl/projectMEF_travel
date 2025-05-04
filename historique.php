<?php
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connecter.php");
    exit();
}

$username = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];
$reservations_utilisateur = [];

$fichier = "reservation.json";
if (file_exists($fichier)) {
    $json = file_get_contents($fichier);
    $all_reservations = json_decode($json, true);

    if (is_array($all_reservations)) {
        foreach ($all_reservations as $index => $reservation) {
            if ($reservation['id_utilisateur'] == $id_utilisateur) {
                $reservation['id'] = $index; // Ajout de l'identifiant pour le paiement
                $reservations_utilisateur[] = $reservation;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Voyages</title>
    <link rel="stylesheet" href="sitedevoyage.css">
    <style>
        .voyage-card {
            position: relative;
            background-color: #fefefe;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 6px solid #ccc;
        }
        .voyage-card.payee {
            border-left-color: #28a745;
        }
        .voyage-card.attente {
            border-left-color: #ffc107;
        }
        .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            color: white;
        }
        .badge.payee {
            background-color: #28a745;
        }
        .badge.attente {
            background-color: #ffc107;
            color: #333;
        }
        .voyage-card p {
            margin: 8px 0;
        }
        .voyage-card h3 {
            margin-top: 0;
        }
        .text-success {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<main class="compte2-section">
    <h1>Mes voyages</h1>

    <?php if (empty($reservations_utilisateur)): ?>
        <p>Vous n’avez encore réservé aucun voyage.</p>
    <?php else: ?>
        <div class="voyages-list">
            <?php foreach ($reservations_utilisateur as $voyage): ?>
                <div class="voyage-card <?= $voyage['statut'] === 'Payé' ? 'payee' : 'attente' ?>">
                    <span class="badge <?= $voyage['statut'] === 'Payé' ? 'payee' : 'attente' ?>">
                        <?= $voyage['statut'] === 'Payé' ? 'PAYÉ ✅' : 'À PAYER 💳' ?>
                    </span>
                    <h3><?= htmlspecialchars(ucfirst($voyage['destination'])) ?></h3>
                    <p>✈️ <strong>Départ :</strong> <?= htmlspecialchars($voyage['date_depart']) ?></p>
                    <p>🛬 <strong>Retour :</strong> <?= htmlspecialchars($voyage['date_retour']) ?></p>
                    <p>💰 <strong>Prix :</strong> <?= htmlspecialchars($voyage['prix']) ?> €</p>
                    <p>📦 <strong>Statut :</strong> <?= htmlspecialchars($voyage['statut']) ?></p>

                    <?php if ($voyage['statut'] === 'En attente'): ?>
                        <form action="paiement.php" method="post">
                            <input type="hidden" name="id_reservation" value="<?= $voyage['id'] ?>">
                            <input type="hidden" name="montant" value="<?= $voyage['prix'] ?>">
                            <input type="hidden" name="destination" value="<?= htmlspecialchars($voyage['destination']) ?>">
                            <button type="submit" class="btn btn-primary">Payer ce voyage</button>
                        </form>
                    <?php else: ?>
                        <p class="text-success">Voyage déjà payé</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
</body>
</html>