<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="payment.php" method="POST">
        <h2>Réservation de votre voyage</h2>
        <label for="depart">Aéroport de départ:</label>
        <input type="text" id="depart" name="depart" required>

        <label for="adulte">Nombre d'adultes:</label>
        <input type="number" id="adulte" name="adulte" min="1" required>

        <label for="enfant">Nombre d'enfants:</label>
        <input type="number" id="enfant" name="enfant" min="0">

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

        <button type="submit">Continuer</button>
    </form>
</body>
</html>
