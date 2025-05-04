<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="sitedevoyage.css">
  <style>
    .error-message {
      color: #dc3545;
      margin: 10px 0;
      padding: 10px;
      border: 1px solid #dc3545;
      border-radius: 5px;
      display: none;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>

<center>
  <div class="container">
    <h2>Connexion Utilisateur</h2>

    <div id="error-message" class="error-message"></div>

    <form id="connexion-form" action="connexion.php" method="POST">
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="mot_de_passe">Mot de passe</label>
        <div style="position: relative;">
          <input type="password" id="mot_de_passe" name="mot_de_passe" required>
          <span id="toggle-password" style="position: absolute; right: 10px; top: 8px; cursor: pointer;">👁</span>
        </div>
      </div>

      <div class="small-text">
        <a href="inscription.php">Mot de passe oublié ?</a><br>
      </div><br>

      <button type="submit" class="btn">Se connecter</button>
    </form>
  </div>
</center>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('connexion-form');
  const email = document.getElementById('email');
  const password = document.getElementById('mot_de_passe');
  const toggle = document.getElementById('toggle-password');
  const errorBox = document.getElementById('error-message');

  // Afficher / cacher mot de passe
  toggle.addEventListener('click', () => {
    password.type = password.type === 'password' ? 'text' : 'password';
    toggle.textContent = password.type === 'password' ? '👁' : '🙈';
  });

  // Validation avant envoi
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Empêche l'envoi

    errorBox.style.display = 'none';
    errorBox.textContent = '';

    const emailVal = email.value.trim();
    const passVal = password.value.trim();

    if (!emailVal.includes('@') || emailVal.length < 5) {
      showError("Veuillez entrer un email valide.");
      return;
    }

    if (passVal.length < 4) {
      showError("Veuillez entrer un mot de passe valide.");
      return;
    }

    // Si tout est bon, on envoie
    form.submit();
  });

  function showError(msg) {
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
    window.scrollTo(0, errorBox.offsetTop - 20);
  }

  // Affiche les messages d’erreur venant de PHP
  const params = new URLSearchParams(window.location.search);
  const error = params.get('error');
  if (error) {
    showError(decodeURIComponent(error));
  }
});
</script>

</body>
</html>
