<?php
session_start(); // Si header/footer l'utilisent ou pour messages futurs

require('getapikey.php'); // Pour récupérer l'API Key

// --- Fichier de données ---
$fichier_reservations = 'reservation.json';

// --- Récupération des données envoyées par CY Bank ---
$id_reservation_key = $_GET['transaction'] ?? ""; // C'est notre id_reservation
$montant_recu = $_GET['montant'] ?? "";
$vendeur_recu = $_GET['vendeur'] ?? "";
$statut_paiement_banque = $_GET['status'] ?? ""; // "accepted" ou "declined"
$control_recu = $_GET['control'] ?? "";

// --- Inclusions pour l'affichage ---
// Inclure le header tôt pour une structure de page cohérente, même en cas d'erreur
include("header.php");

// --- Vérification initiale des valeurs ---
if (!$id_reservation_key || !$montant_recu || !$vendeur_recu || !$statut_paiement_banque || !$control_recu) {
    echo "<h2 style='color:red;'>Erreur : Informations de paiement incomplètes reçues de la banque.</h2>";
    echo "<p>Veuillez contacter le support si le problème persiste.</p>";
    include 'footer.php';
    exit();
}

// --- Récupération de l'API Key du vendeur ---
$api_key = getAPIKey($vendeur_recu);
if (!$api_key) {
    error_log("API Key non trouvée pour le vendeur: " . htmlspecialchars($vendeur_recu) . " dans retour_paiement.php");
    echo "<h2 style='color:red;'>Erreur de configuration du paiement.</h2>";
    echo "<p>Impossible de vérifier la transaction. Veuillez contacter le support.</p>";
    include 'footer.php';
    exit();
}

// --- Vérification de la valeur de contrôle (intégrité des données) ---
$control_calcule = md5($api_key . "#" . $id_reservation_key . "#" . $montant_recu . "#" . $vendeur_recu . "#" . $statut_paiement_banque . "#");

if ($control_recu !== $control_calcule) {
    error_log("Tentative de fraude ou erreur de contrôle détectée. Control reçu: $control_recu, Calculé: $control_calcule. Transaction: " . htmlspecialchars($id_reservation_key));
    echo "<h2 style='color:red;'>Erreur : Données de paiement invalides.</h2>";
    echo "<p>L'intégrité de la transaction n'a pas pu être vérifiée. Veuillez contacter le support.</p>";
    include 'footer.php';
    exit();
}

// --- Traitement du statut du paiement et mise à jour de la réservation ---
$message_reservation_update = ""; // Pour stocker le message sur la mise à jour du JSON

if ($statut_paiement_banque === "accepted") {
    echo "<h2 style='color:green;'>✅ Paiement accepté par la banque pour un montant de " . htmlspecialchars($montant_recu) . " €.</h2>";

    // Mise à jour du statut dans reservation.json
    if (!file_exists($fichier_reservations)) {
        $message_reservation_update = "<p style='color:orange;'>Attention : Fichier des réservations (`" . htmlspecialchars($fichier_reservations) . "`) introuvable. Le statut de la réservation n'a pas pu être mis à jour automatiquement.</p>";
        error_log("Fichier de réservation non trouvé : " . $fichier_reservations . " lors du retour de paiement pour la transaction " . htmlspecialchars($id_reservation_key));
    } else {
        $json_contenu = file_get_contents($fichier_reservations);
        $reservations = json_decode($json_contenu, true);

        if ($reservations === null && json_last_error() !== JSON_ERROR_NONE) {
            $message_reservation_update = "<p style='color:red;'>Erreur critique : Le fichier des réservations est corrompu. Le statut n'a pas pu être mis à jour.</p>";
            error_log("Erreur de décodage JSON dans " . $fichier_reservations . " pour transaction " . htmlspecialchars($id_reservation_key) . ": " . json_last_error_msg());
        } elseif (!is_array($reservations) ) { //  On s'attend à un objet (tableau associatif) à la racine
             $message_reservation_update = "<p style='color:red;'>Erreur critique : La structure du fichier des réservations est incorrecte. Le statut n'a pas pu être mis à jour.</p>";
            error_log("Structure incorrecte dans " . $fichier_reservations . " pour transaction " . htmlspecialchars($id_reservation_key) . ". Attendu un objet JSON à la racine.");
        }
        // L'ID de réservation est la clé. Utiliser (string) pour la cohérence.
        elseif (isset($reservations[$id_reservation_key])) {
            if ($reservations[(string)$id_reservation_key]['status'] !== "Payée") {
                $reservations[(string)$id_reservation_key]['status'] = "Payée";
                $reservations[(string)$id_reservation_key]['date_paiement_confirme'] = date('Y-m-d H:i:s');
                // Vous pouvez aussi stocker $montant_recu ou d'autres infos de la banque ici si pertinent
                // $reservations[(string)$id_reservation_key]['montant_confirme_banque'] = (float)$montant_recu;

                if (file_put_contents($fichier_reservations, json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false) {
                    $message_reservation_update = "<p style='color:green;'>Le statut de votre réservation ID <strong>" . htmlspecialchars($id_reservation_key) . "</strong> a été mis à jour à 'Payée'.</p>";
                } else {
                    $message_reservation_update = "<p style='color:red;'>Erreur : Impossible de sauvegarder la mise à jour du statut pour la réservation ID " . htmlspecialchars($id_reservation_key) . ".</p>";
                    error_log("Échec de file_put_contents pour " . $fichier_reservations . " lors de la mise à jour de la transaction " . htmlspecialchars($id_reservation_key));
                }
            } else {
                $message_reservation_update = "<p style='color:blue;'>Information : Le paiement pour la réservation ID <strong>" . htmlspecialchars($id_reservation_key) . "</strong> était déjà marqué comme 'Payée'.</p>";
            }
        } else {
            $message_reservation_update = "<p style='color:orange;'>Attention : Réservation ID '<strong>" . htmlspecialchars($id_reservation_key) . "</strong>' non trouvée dans notre système. Le statut n'a pas pu être mis à jour. Veuillez vérifier l'ID de transaction.</p>";
            error_log("Réservation non trouvée pour l'ID (transaction CY Bank): " . htmlspecialchars($id_reservation_key) . " dans " . $fichier_reservations);
        }
    }
    echo $message_reservation_update;

} else { // Statut "declined" ou autre
    echo "<h2 style='color:red;'>❌ Paiement refusé par la banque.</h2>";
    // Optionnel: Mettre à jour le statut à "Paiement échoué" dans reservation.json
    // Pour l'instant, on ne touche pas au JSON en cas de refus, mais vous pourriez ajouter une logique similaire à ci-dessus.
    /*
    if (file_exists($fichier_reservations)) {
        $json_contenu = file_get_contents($fichier_reservations);
        $reservations = json_decode($json_contenu, true);
        if ($reservations && isset($reservations[(string)$id_reservation_key]) && $reservations[(string)$id_reservation_key]['statut'] !== "Payée") {
            $reservations[(string)$id_reservation_key]['statut'] = "Paiement échoué";
            $reservations[(string)$id_reservation_key]['date_echec_paiement'] = date('Y-m-d H:i:s');
            file_put_contents($fichier_reservations, json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
            echo "<p style='color:orange;'>Le statut de la réservation ID ".htmlspecialchars($id_reservation_key)." a été noté comme 'Paiement échoué'.</p>";
        }
    }
    */
    echo "<p>Aucune modification apportée au statut de votre réservation suite à ce refus.</p>";
}

echo "<p><a href='historique.php'>Consulter l'historique des réservations</a></p>";

include 'footer.php';
?>