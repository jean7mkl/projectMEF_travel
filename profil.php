<?php
include("verif_statut.php");
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connecter.php");
    exit();
}

$login = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];
$message = "";

// Recherche dans les deux fichiers
$fichiers = ['utilisateurs.json', 'administrateur.json'];
$utilisateur_actuel = null;
$fichier_courant = null;

foreach ($fichiers as $fichier) {
    if (!file_exists($fichier)) continue;
    $utilisateurs = json_decode(file_get_contents($fichier), true);
    foreach ($utilisateurs as $index => $u) {
        if ($u['id'] == $id_utilisateur) {
            $utilisateur_actuel = &$utilisateurs[$index]; // ✅ référence
            $fichier_courant = $fichier;
            break 2;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    if ($utilisateur_actuel) {
        $utilisateur_actuel['informations']['nom'] = $nom;
        $utilisateur_actuel['informations']['email'] = $email;
        $utilisateur_actuel['informations']['telephone'] = $telephone;

        // ✅ Sauvegarde dans le bon fichier
        file_put_contents($fichier_courant, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $_SESSION['nom'] = $nom;
        $message = "Informations mises à jour avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <link rel="stylesheet" href="sitedevoyage.css">
   <style>main.compte2-section {
  max-width: 600px;
  margin: 50px auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  padding: 30px;
}

h1 {
  text-align: center;
  color: #5a3921;
  margin-bottom: 25px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  padding: 12px;
  border-radius: 5px;
  margin-bottom: 20px;
  text-align: center;
  font-weight: bold;
}

.profil-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: 100px 1fr auto;
  align-items: center;
  gap: 10px;
}

.form-row label {
  font-weight: bold;
  color: #444;
}

.form-row input {
  padding: 10px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #fefefe;
}

.form-row input:disabled {
  background-color: #f2f2f2;
  color: #888;
}

.actions button {
  padding: 6px 10px;
  background-color: #b5651d;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
}

.actions button:hover {
  background-color: #8d470a;
}

#submit-container {
  text-align: center;
  margin-top: 20px;
}

#submit-container .btn {
  background-color: #b5651d;
  color: white;
  padding: 10px 20px;
  font-size: 17px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
}

#submit-container .btn:hover {
  background-color: #8d470a;
}

</style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="compte2-section">
    <h1>Mon profil</h1>

    <?php if (!empty($message)): ?>
        <div class="alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="profil-form" id="profilForm">
        <?php
        $infos = $utilisateur_actuel['informations'];
        foreach (['nom', 'email', 'telephone'] as $champ):
            $val = htmlspecialchars($infos[$champ] ?? '');
        ?>
        <div class="form-row">
            <label for="<?= $champ ?>"><?= ucfirst($champ) ?> :</label>
            <input type="<?= $champ === 'email' ? 'email' : 'text' ?>" id="<?= $champ ?>" name="<?= $champ ?>" value="<?= $val ?>" disabled>
            <div class="actions">
                <button type="button" onclick="enableEdit('<?= $champ ?>')">✏️</button>
                <button type="button" onclick="cancelEdit('<?= $champ ?>')" style="display:none;">❌</button>
            </div>
        </div>
        <?php endforeach; ?>

        <div id="submit-container" style="display:none;">
            <button type="submit" class="btn btn-primary">💾 Soumettre les modifications</button>
        </div>
    </form>
</main>

<?php include 'footer.php'; ?>

<script>
const originalValues = {};

function enableEdit(field) {
    const input = document.getElementById(field);
    const buttons = input.parentElement.querySelectorAll('button');
    if (!(field in originalValues)) {
        originalValues[field] = input.value;
    }

    input.disabled = false;
    buttons[0].style.display = 'none'; // ✏️
    buttons[1].style.display = 'inline-block'; // ❌
    document.getElementById('submit-container').style.display = 'block';
}

function cancelEdit(field) {
    const input = document.getElementById(field);
    const buttons = input.parentElement.querySelectorAll('button');

    input.value = originalValues[field];
    input.disabled = true;
    buttons[0].style.display = 'inline-block'; // ✏️
    buttons[1].style.display = 'none'; // ❌

    let modifActive = false;
    document.querySelectorAll('.profil-form input').forEach(i => {
        if (!i.disabled) modifActive = true;
    });
    if (!modifActive) {
        document.getElementById('submit-container').style.display = 'none';
    }
}
</script>

</body>
</html>
