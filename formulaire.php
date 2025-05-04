<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Traductions des codes de destination
$traductions = [
    "famille" => "En famille",
    "amis" => "Entre amis",
    "amoureux" => "En amoureux",
    "montagne" => "Détente à la montagne",
    "ville-famille" => "Vacances en ville",
    "plage-famille" => "Vacances à la plage",
    "ete-montagne" => "Été à Chamonix",
    "hiver-montagne" => "Hiver à Megève",
    "ville-amis" => "Visite en ville",
    "courchevel" => "Fiesta à Courchevel",
    "barcelone" => "Fête à Barcelone",
    "maldives" => "Plage aux Maldives",
    "suisse" => "Ski en Suisse"
];

// Destination passée en GET
$code = $_GET['destination'] ?? null;
$destination_traduite = $traductions[$code] ?? "Non spécifiée";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de réservation</title>
    <link rel="stylesheet" href="sitedevoyage.css">
</head>
<body>
<?php include 'header.php'; ?>
<center>
<div class="container">
    <h2>Formulaire de réservation</h2>

    <div class="text">
        Votre destination sélectionnée est : <strong><?= htmlspecialchars($destination_traduite) ?></strong>
    </div>

    <form action="reservation.php" method="post" class="reservation-form">
        <input type="hidden" name="destination" value="<?= htmlspecialchars($destination_traduite) ?>">

        <label for="depart">Aéroport de départ:</label>
        <input type="text" id="depart" name="depart" required>

        <label for="adulte">Nombre d'adultes:</label>
        <input type="number" id="adulte" name="adulte" min="1" value="1" required>

        <label for="enfant">Nombre d'enfants:</label>
        <input type="number" id="enfant" name="enfant" min="0" value="0">

        <label for="date_depart">Date de départ:</label>
        <input type="date" id="date_depart" name="date_depart" required>

        <label for="date_retour">Date de retour:</label>
        <input type="date" id="date_retour" name="date_retour" required>

        <label for="classe">Classe:</label>
        <select id="classe" name="classe">
            <option value="eco">Économie</option>
            <option value="business">Business</option>
            <option value="first">Première</option>
        </select>

        <label for="bagage">Bagages:</label>
        <select id="bagage" name="bagage">
            <option value="cabine">Cabine</option>
            <option value="soute">Soute</option>
        </select>

        <label for="assurance">Assurance voyage:</label>
        <input type="checkbox" id="assurance" name="assurance">

        <button type="submit" class="btn">Continuer</button>
    </form>
</div>
<center/>
<?php include 'footer.php'; ?>
</body>
</html>
