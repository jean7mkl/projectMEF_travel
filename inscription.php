<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fichier_utilisateurs = __DIR__ . '/voyageurs.json';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['nom', 'prenom', 'sexe', 'email', 'telephone', 'mot_de_passe'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("Erreur : Le champ '$field' est requis.");
        }
    }

    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $sexe = $_POST["sexe"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST["telephone"]));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : L'email n'est pas valide.");
    }
    if (!preg_match('/^\+?[0-9]{10,15}$/', $telephone)) {
        die("Erreur : Numéro de téléphone invalide.");
    }

    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    $utilisateurs = [];
    if (file_exists($fichier_utilisateurs)) {
        $contenu = file_get_contents($fichier_utilisateurs);
        if ($contenu === false) {
            die("Erreur : Impossible de lire le fichier utilisateurs.");
        }

        $utilisateurs = json_decode($contenu, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Erreur : Fichier JSON corrompu. " . json_last_error_msg());
        }
    }

    foreach ($utilisateurs as $user) {
        if (strcasecmp($user['informations']['email'], $email) === 0) {
            die("Erreur : Cet email est déjà utilisé.");
        }
    }

    $base_login = strtolower($prenom . '.' . $nom);
    $login = $base_login;
    $i = 1;
    while (array_search($login, array_column($utilisateurs, 'login')) !== false) {
        $login = $base_login . $i;
        $i++;
    }

    $nouvel_utilisateur = [
        "id" => count($utilisateurs) > 0 ? max(array_column($utilisateurs, 'id')) + 1 : 1,
        "login" => $login,
        "mot_de_passe" => $mot_de_passe,
        "role" => "utilisateur",
        "informations" => [
            "nom" => "$nom $prenom",
            "email" => $email,
            "telephone" => $telephone,
            "sexe" => $sexe
        ],
        "voyages" => [
            "consultes" => [],
            "achetes" => []
        ]
    ];

    try {
        $json_data = json_encode($utilisateurs, JSON_PRETTY_PRINT);
        if ($json_data === false) {
            throw new Exception("Erreur d'encodage JSON: " . json_last_error_msg());
        }

        $utilisateurs[] = $nouvel_utilisateur;
        $result = file_put_contents($fichier_utilisateurs, json_encode($utilisateurs, JSON_PRETTY_PRINT), LOCK_EX);
        if ($result === false) {
            throw new Exception("Erreur lors de l'écriture dans le fichier.");
        }

        echo "<p>Inscription réussie ! Redirection dans 5 secondes...</p>";
        echo "<p><a href='connecter.php'>Cliquez ici si la redirection ne fonctionne pas</a></p>";
        header("Refresh: 5; url=connecter.php");

    } catch (Exception $e) {
        die("Erreur critique : " . $e->getMessage() . 
            "<br>Veuillez contacter l'administrateur si le problème persiste.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="sitedevoyage.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        .error-message {
            color: #dc3545;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #dc3545;
            border-radius: 5px;
            display: none;
        }
        .success-message {
            color: #28a745;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #28a745;
            border-radius: 5px;
            display: none;
        }
        .form-group div {
            margin-top: 5px;
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

<center><br><br><br>
    <main>
        <div class="container">
            <h2>Formulaire d'inscription</h2>

            <div id="error-message" class="error-message"></div>
            <div id="success-message" class="success-message"></div>

            <form id="inscription-form" action="inscription.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom*</label>
                    <input type="text" id="nom" name="nom" required minlength="2" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom*</label>
                    <input type="text" id="prenom" name="prenom" required minlength="2" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="sexe">Sexe*</label>
                    <select id="sexe" name="sexe" required>
                        <option value="">Sélectionner</option>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">E-mail*</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Numéro de téléphone*</label>
                    <input type="tel" id="telephone" name="telephone" required pattern="^\+?[0-9]{10,15}$">
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe*</label>
                    <div style="position: relative;">
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="8" maxlength="30">
                        <span id="toggle-password" style="position: absolute; right: 10px; top: 8px; cursor: pointer;">👁</span>
                    </div>
                    <div id="password-counter">0 / 30</div>
                </div>
                <div class="form-group">
                    <label for="confirmation_mot_de_passe">Confirmer le mot de passe*</label>
                    <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
                </div>

                <button type="submit" class="btn">S'inscrire</button>
            </form>
        </div>
    </main>
</center><br><br><br>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('inscription-form');
  const passwordInput = document.getElementById('mot_de_passe');
  const confirmInput = document.getElementById('confirmation_mot_de_passe');
  const counter = document.getElementById('password-counter');
  const toggle = document.getElementById('toggle-password');
  const errorBox = document.getElementById('error-message');

  passwordInput.addEventListener('input', () => {
    counter.textContent = `${passwordInput.value.length} / ${passwordInput.maxLength}`;
  });

  toggle.addEventListener('click', () => {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = confirmInput.type = type;
    toggle.textContent = type === 'password' ? '👁' : '🙈';
  });

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    errorBox.style.display = 'none';
    errorBox.textContent = '';

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const tel = document.getElementById('telephone').value.trim();
    const password = passwordInput.value.trim();
    const confirm = confirmInput.value.trim();
    const sexe = document.getElementById('sexe').value;

    if (nom.length < 2 || prenom.length < 2) {
      showError("Nom et prénom doivent contenir au moins 2 caractères.");
      return;
    }

    if (!email.includes("@")) {
      showError("Email invalide.");
      return;
    }

    if (!/^\+?[0-9]{10,15}$/.test(tel)) {
      showError("Numéro de téléphone invalide.");
      return;
    }

    if (password.length < 8) {
      showError("Le mot de passe doit contenir au moins 8 caractères.");
      return;
    }

    if (password !== confirm) {
      showError("Les mots de passe ne correspondent pas.");
      return;
    }

    if (sexe === "") {
      showError("Veuillez sélectionner un sexe.");
      return;
    }

    form.submit();
  });

  function showError(msg) {
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
    window.scrollTo(0, errorBox.offsetTop - 20);
  }
});
</script>
</body>
</html>
