<?php
session_start();
require('getapikey.php');
$fichier = 'reservation.json';

// 1) Récupérer les paramètres
$id_resa     = isset($_GET['id_reservation']) ? (int)$_GET['id_reservation'] : null;
$transaction = $_GET['transaction']            ?? '';
$status      = $_GET['status']                 ?? '';
$montant_rec = $_GET['montant']                ?? '';
$vendeur     = $_GET['vendeur']                ?? '';
$control_rec = $_GET['control']                ?? '';

// 2) Lire le JSON
$reservs = json_decode(file_get_contents($fichier), true);
$exists  = $id_resa !== null && isset($reservs[$id_resa]);

// 3) Vérifier montant & transaction
$ok_montant = $exists && (float)$montant_rec === (float)$reservs[$id_resa]['prix'];
$ok_txn     = $exists && $transaction === ($reservs[$id_resa]['transaction'] ?? '');

// 4) Mettre à jour si OK
$success = $exists && $ok_montant && $ok_txn && $status === 'accepted';
if ($success) {
    $reservs[$id_resa]['status'] = 'Payé';
    $reservs[$id_resa]['date_paiement_confirme'] = date('Y-m-d H:i:s');
    file_put_contents(
        $fichier,
        json_encode($reservs, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),
        LOCK_EX
    );
}

include 'header.php';
?>

<main class="compte2-section" style="text-align:center; padding: 2rem;">
  <?php if ($success): ?>
    <div class="voyage-card payee" style="display:inline-block; max-width:400px;">
      <h2 class="text-success">✅ Paiement validé</h2>
      <p>Montant : <strong><?= htmlspecialchars($montant_rec) ?> €</strong></p>
      <p>ID Réservation : <strong><?= htmlspecialchars($id_resa) ?></strong></p>
      <a href="historique.php" class="btn btn-primary">← Retour à l'historique</a>
    </div>
  <?php else: ?>
    <div class="voyage-card attente" style="display:inline-block; max-width:400px;">
      <h2 style="color:#d9534f;">❌ Paiement non validé</h2>
      <?php if (!$exists): ?>
        <p>Réservation introuvable ou paramètres manquants.</p>
      <?php elseif (!$ok_montant): ?>
        <p>Le montant reçu ne correspond pas.</p>
      <?php elseif (!$ok_txn): ?>
        <p>Transaction invalide.</p>
      <?php else: ?>
        <p>Statut renvoyé : <strong><?= htmlspecialchars($status) ?></strong></p>
      <?php endif; ?>
      <a href="historique.php" class="btn btn-secondary">← Retour à l'historique</a>
    </div>
  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
