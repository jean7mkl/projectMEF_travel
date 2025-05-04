<?php
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connecter.php");
    exit();
}

$login = $_SESSION['login'];
$id_utilisateur = $_SESSION['id_utilisateur'];
$fichier = 'utilisateurs.json';
$message = "";

$utilisateurs = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];

$utilisateur_actuel = null;
foreach ($utilisateurs as $index => $u) {
    if ($u['id'] == $id_utilisateur) {
        $utilisateur_actuel = &$utilisateurs[$index];
        break;
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

        file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));
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
    <style>
        .profil-form {
            max-width: 600px;
            margin: auto;
        }
        .form-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        .form-row label {
            width: 100px;
            font-weight: bold;
        }
        .form-row input {
            flex: 1;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .actions button {
            padding: 6px 10px;
            border: none;
            background-color: #B5651D;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions button:hover {
            opacity: 0.9;
        }
        #submit-container {
            text-align: center;
            margin-top: 20px;
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
            $val = htmlspecialchars($infos[$champ]);
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

    // Cacher le bouton soumettre si aucune modif active
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
