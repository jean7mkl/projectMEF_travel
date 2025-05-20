<?php
require('getapikey.php'); // Nécessaire pour récupérer l'API Key

// Récupération des données envoyées par CY Bank
$transaction = $_GET['transaction'] ?? "";
$montant = $_GET['montant'] ?? "";
$vendeur = $_GET['vendeur'] ?? "";
$statut = $_GET['statut'] ?? ""; // accepted ou declined
$control_recu = $_GET['control'] ?? "";

// Vérification des valeurs
if (!$transaction || !$montant || !$vendeur || !$statut || !$control_recu) {
    die("Erreur : Informations de paiement incomplètes !");
}

// Récupération de l'API Key du vendeur
$api_key = getAPIKey($vendeur);

// Vérification de la valeur de contrôle
$control_calcule = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control_recu !== $control_calcule) {
    die("Erreur : Données invalides (intégrité non respectée) !");
}

// Affichage du résultat
if ($statut === "accepted") {
    echo "<h2 style='color:green;'>✅ Paiement accepté pour un montant de $montant €.</h2>";
} else {
    echo "<h2 style='color:red;'>❌ Paiement refusé.</h2>";
}
?>
