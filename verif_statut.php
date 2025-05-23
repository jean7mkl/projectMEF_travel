<?php
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    exit(); // ou redirection vers la page de connexion
}

$fichier = 'voyageurs.json';
if (!file_exists($fichier)) exit();

$utilisateurs = json_decode(file_get_contents($fichier), true);
$statut = 'normal'; // Par défaut

foreach ($utilisateurs as $u) {
    if ((int)$u['id'] === (int)$_SESSION['id_utilisateur']) {
        $statut = $u['statut'] ?? 'normal';
        break;
    }
}

if ($statut === 'banni') {
    // ❌ Redirection immédiate ou message
    session_destroy();
    header("Location: banni.php");
    exit();
}
