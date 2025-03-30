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

// Charge les données utilisateurs
$utilisateurs = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];

// Trouve l'utilisateur courant
$utilisateur_actuel = null;
foreach ($utilisateurs as $index => $u) {
    if ($u['id'] == $id_utilisateur) {
        $utilisateur_actuel = &$utilisateurs[$index];
        break;
    }
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    if ($utilisateur_actuel) {
        $utilisateur_actuel['informations']['nom'] = $nom;
        $utilisateur_actuel['informations']['email'] = $email;
        $utilisateur_actuel['informations']['telephone'] = $telephone;

        file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));
        $_SESSION['nom'] = $nom; // Mise à jour dans la session aussi
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
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo-title">
            <a href="projet.php" class="logo-link">
                <img src="photo/Logo.png" alt="Logo Travel4all" class="logo">
            </a>
            <h1>WHERE2GO</h1>
        </div>

        <nav>
            <a href="projet.php" class="btn-nav">Accueil</a>
            <a href="pagequizz.php" class="btn-nav">Notre concept</a>
            <a href="présprojet.php" class="btn-nav">Qui sommes-nous?</a>
        </nav>

        <div class="header-auth">
            <a href="moncompte.php" class="btn btn-primary"><?php echo $login; ?></a>
            <a href="déconnexion.php" class="btn btn-primary">Se déconnecter</a>
        </div>
    </div>
</header>

<main class="compte2-section">
    <h1>Mon profil</h1>

    <?php if (!empty($message)): ?>
        <div class="alert-success"> <?php echo $message; ?> </div>
    <?php endif; ?>

    <form method="POST" class="profil-form">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($utilisateur_actuel['informations']['nom']); ?>" required>

        <label>Email :</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($utilisateur_actuel['informations']['email']); ?>" required>

        <label>Téléphone :</label>
        <input type="text" name="telephone" value="<?php echo htmlspecialchars($utilisateur_actuel['informations']['telephone']); ?>" required>

        <button type="submit">Enregistrer</button>
    </form>
</main>

<footer>
    <p>&copy; 2025 Agence de Voyage de Léo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
</footer>

</body>
</html>
