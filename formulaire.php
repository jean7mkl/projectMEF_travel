<?php
session_start();

// Traductions des codes de destination
$traductions = [
    "famille"        => "En famille",
    "amis"           => "Entre amis",
    "amoureux"       => "En amoureux",
    "montagne"       => "Détente à la montagne",
    "ville-famille"  => "Vacances en ville",
    "plage-famille"  => "Vacances à la plage",
    "ete-montagne"   => "Été à Chamonix",
    "hiver-montagne" => "Hiver à Megève",
    "ville-amis"     => "Visite en ville",
    "courchevel"     => "Fiesta à Courchevel",
    "barcelone"      => "Fête à Barcelone",
    "maldives"       => "Plage aux Maldives",
    "suisse"         => "Ski en Suisse",
    "newyork"        => "New York",
    "megeve"         => "Megève",
    "caraibes"       => "Les Caraïbes",
    "coteazur"       => "La Côte d’Azur",
    "chamonix"       => "Chamonix",
    // ajoute ici toutes tes clés **exactement** telles que passées en ?dest=
];

// On récupère **dest**, pas destination
$code = $_GET['dest'] ?? null;
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

<main style="display:flex; justify-content:center; padding:40px 0;">
  <div class="container" style="max-width:400px; width:100%;">
    <h2 style="text-align:center; margin-bottom:1.5rem;">Formulaire de réservation</h2>

    <div style="
      background:#fafafa;
      border-left:6px solid #a15e2c;
      padding:1rem;
      border-radius:8px;
      margin-bottom:1.5rem;
      box-shadow:0 2px 8px rgba(0,0,0,0.05);
    ">
      Votre destination sélectionnée est : 
      <strong style="color:#a15e2c;"><?= htmlspecialchars($destination_traduite) ?></strong>
    </div>

    <form action="reservation.php" method="post" class="reservation-form">
      <!-- On transmet la valeur traduite pour la suite -->
      <input type="hidden" name="destination" value="<?= htmlspecialchars($destination_traduite, ENT_QUOTES) ?>">

      <label for="depart">Aéroport de départ :</label>
      <input type="text" id="depart" name="depart" required>

      <label for="adulte">Nombre d'adultes :</label>
      <input type="number" id="adulte" name="adulte" min="1" value="1" required>

      <label for="enfant">Nombre d'enfants :</label>
      <input type="number" id="enfant" name="enfant" min="0" value="0">

      <label for="date_depart">Date de départ :</label>
      <input type="date" id="date_depart" name="date_depart" required>

      <label for="date_retour">Date de retour :</label>
      <input type="date" id="date_retour" name="date_retour" required>

      <label for="classe">Classe :</label>
      <select id="classe" name="classe">
        <option value="eco">Économie</option>
        <option value="business">Business</option>
        <option value="first">Première</option>
      </select>

      <label for="bagage">Bagages :</label>
      <select id="bagage" name="bagage">
        <option value="cabine">Cabine</option>
        <option value="soute">Soute</option>
      </select>

      <label for="assurance">
        <input type="checkbox" id="assurance" name="assurance">
        Assurance voyage (+60 €)
      </label>

      <button type="submit" class="btn btn-primary" style="width:100%; margin-top:1rem;">
        Continuer
      </button>
    </form>
  </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
