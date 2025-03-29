<?php
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connecter.php");
    exit();
}

$username = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];

$message = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination = htmlspecialchars($_POST['destination']);
    $date_depart = $_POST['date_depart'];
    $date_retour = $_POST['date_retour'];
    $prix = floatval($_POST['prix']);
    $statut = "en attente";

    $reservation = [
        "id_reservation" => time(), // ID unique basé sur le timestamp
        "id_utilisateur" => $id_utilisateur,
        "destination" => $destination,
        "date_depart" => $date_depart,
        "date_retour" => $date_retour,
        "prix" => $prix,
        "statut" => $statut
    ];

    $fichier = "reservation.json";
    if (!is_writable($fichier)) {
        echo "❌ Le fichier reservation.json n'est pas accessible en écriture.";
        exit();
    }
    
    $reservations = [];

    if (file_exists($fichier)) {
        $reservations = json_decode(file_get_contents($fichier), true);
    }

    $reservations[] = $reservation;
    file_put_contents($fichier, json_encode($reservations, JSON_PRETTY_PRINT));
    $message = "Réservation enregistrée avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver un voyage</title>
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
            <a href="deconnexion.php" class="btn btn-primary">Se déconnecter</a>
        </div>
    </div>
</header>

<main class="compte2-section">
    <h1>Réserver un nouveau voyage :</h1>

    <?php if (!empty($message)): ?>
        <div class="alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" class="reservation-form">
        <label>Destination :</label>
        <input type="text" name="destination" required>

        <label>Date de départ :</label>
        <input type="date" name="date_depart" required>

        <label>Date de retour :</label>
        <input type="date" name="date_retour" required>

        <label>Prix estimé (€) :</label>
        <input type="number" name="prix" step="0.01" required>

        <button type="submit">Valider la réservation</button>
    </form>
</main>

<footer>
    <p>&copy; 2025 Agence de Voyage de Léo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
</footer>

</body>
</html>
