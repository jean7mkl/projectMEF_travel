<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Chemin absolu vers le fichier JSON
$fichier_utilisateurs = __DIR__ . '/utilisateurs.json';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des champs obligatoires
    $required_fields = ['nom', 'prenom', 'sexe', 'email', 'telephone', 'mot_de_passe'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("Erreur : Le champ '$field' est requis.");
        }
    }

    // Nettoyage et validation des données
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $sexe = $_POST["sexe"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST["telephone"]));

    // Validation des données
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : L'email n'est pas valide.");
    }
    if (!preg_match('/^\+?[0-9]{10,15}$/', $telephone)) {
        die("Erreur : Numéro de téléphone invalide.");
    }

    // Hachage du mot de passe
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    // Charger les utilisateurs existants avec gestion des erreurs
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

    // Vérifier l'unicité de l'email
    foreach ($utilisateurs as $user) {
        if (strcasecmp($user['informations']['email'], $email) === 0) {
            die("Erreur : Cet email est déjà utilisé.");
        }
    }

    // Générer un login unique
    $base_login = strtolower($prenom . '.' . $nom);
    $login = $base_login;
    $i = 1;
    while (array_search($login, array_column($utilisateurs, 'login')) !== false) {
        $login = $base_login . $i;
        $i++;
    }

    // Créer le nouvel utilisateur
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

    // Ajouter le nouvel utilisateur
    $utilisateurs[] = $nouvel_utilisateur;

    // Sauvegarder avec gestion des erreurs et verrouillage
    try {
        $json_data = json_encode($utilisateurs, JSON_PRETTY_PRINT);
        if ($json_data === false) {
            throw new Exception("Erreur d'encodage JSON: " . json_last_error_msg());
        }

        $result = file_put_contents($fichier_utilisateurs, $json_data, LOCK_EX);
        if ($result === false) {
            throw new Exception("Erreur lors de l'écriture dans le fichier.");
        }

        // Message de succès avec redirection automatique après 5 secondes
        echo "<p>Inscription réussie ! Redirection dans 5 secondes...</p>";
        echo "<p><a href='connecter.html'>Cliquez ici si la redirection ne fonctionne pas</a></p>";
        header("Refresh: 5; url=connecter.html");
        
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
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo-title">
                <a href="projet.html" class="logo-link">
                    <img src="photo/Logo.png" alt="Logo Travel4all" class="logo">
                </a>
                <h1>WHERE2GO</h1>
            </div>
            <nav>
                <a href="projet.php" class="btn-nav">Notre Accueil</a>
                <a href="pagequizz.php" class="btn-nav">Découvrir notre concept</a>
                <a href="présprojet.php" class="btn-nav">Qui sommes-nous?</a>
            </nav>
            <div class="header-auth">
            <?php if (isset($_SESSION['login'])) : ?>
                <!-- Bouton "Client" -->
                <a href="moncompte.php" class="btn btn-primary"><?php echo htmlspecialchars($_SESSION["login"]); ?></a>
                <a href="déconnexion.php" class="btn btn-secondary">Se déconnecter</a>
            <?php else : ?>
                <!-- Boutons pour les non-connectés -->
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            <?php endif; ?>
        </div>
        </div>
    </header>
<center> </br> </br> </br>
    <main>
        <div class="container">
            <h2>Formulaire d'inscription</h2>
            
            <!-- Messages d'erreur/succès -->
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
                    <input type="tel" id="telephone" name="telephone" required 
                           pattern="^\+?[0-9]{10,15}$" 
                           title="Format: +XXXXXXXXXXX ou XXXXXXXXXX (10-15 chiffres)">
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe*</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required 
                           minlength="8" 
                           title="8 caractères minimum">
                </div>
                <div class="form-group">
                    <label for="confirmation_mot_de_passe">Confirmer le mot de passe*</label>
                    <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
                </div>
                
                <button type="submit" class="btn">S'inscrire</button>
            </form>
        </div>
    </main>
    </center> </br> </br> </br>
    <footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p>
    </footer>

    <script>
        document.getElementById('inscription-form').addEventListener('submit', function(e) {
            // Validation côté client
            const password = document.getElementById('mot_de_passe').value;
            const confirmPassword = document.getElementById('confirmation_mot_de_passe').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showMessage('error-message', 'Les mots de passe ne correspondent pas.');
                return false;
            }
            
            return true;
        });

        // Afficher les messages d'erreur venant de PHP
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        if (error) {
            showMessage('error-message', decodeURIComponent(error));
        }
        
        const success = urlParams.get('success');
        if (success) {
            showMessage('success-message', decodeURIComponent(success));
        }

        function showMessage(elementId, message) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.style.display = 'block';
            
            if (elementId === 'success-message') {
                setTimeout(() => {
                    window.location.href = 'connecter.php';
                }, 5000);
            }
        }
    </script>
</body>
</html>