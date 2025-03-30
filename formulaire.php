<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["login"])) {
    header("Location: connecter.php");
    exit();
}

// Chemin vers le fichier JSON
$fichier_choix = "choixutilisateurs.json";

// Récupérer les données de l'utilisateur
$donnees_utilisateur = [];
if (file_exists($fichier_choix)) {
    $contenu = file_get_contents($fichier_choix);
    $tous_choix = json_decode($contenu, true);
    $donnees_utilisateur = $tous_choix[$_SESSION["login"]] ?? [];
}

// Traductions pour affichage plus propre
$traductions = [
    "famille" => "En famille",
    "amis" => "Entre amis",
    "amoureux" => "En amoureux",
    "montagne" => "Détente à la montagne",
    "ville-famille" => "Vacances en ville",
    "plage-famille" => "Vacances à la plage",
    "ete-montagne" => "Été",
    "hiver-montagne" => "Hiver",
    "ville-amis" => "Visite en ville",
    "courchevel" => "Fiesta à la montagne",
    "barcelone" => "Fête à la plage",
    "maldives" => "Plage aux Maldives",
    "suisse" => "Ski en Suisse"
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résumé de vos choix - WHERE2GO</title>
    <link rel="stylesheet" href="sitedevoyage.css">
    <style>
        .resume-container {
            background: #FFF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
        }
        .resume-title {
            color: #B5651D;
            text-align: center;
            margin-bottom: 30px;
        }
        .resume-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #F5F2EB;
            border-radius: 5px;
        }
        .resume-section h3 {
            color: #5D4037;
            border-bottom: 1px solid #E6D0B5;
            padding-bottom: 5px;
        }
        .resume-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .resume-label {
            font-weight: bold;
            color: #5D4037;
        }
        .resume-value {
            color: #8B4513;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
        }
        .btn-primary {
            background: #B5651D;
            color: white;
            border: none;
        }
        .btn-secondary {
            background: #F5E1C8;
            color: #5D4037;
            border: 1px solid #E6D0B5;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
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
                <a href="projet.php" class="btn-nav">Notre Accueil</a>
                <a href="pagequizz.php" class="btn-nav">Découvrir notre concept</a>
                <a href="présprojet.php" class="btn-nav">Qui sommes-nous?</a>
            </nav>
            <div class="header-auth">
                <span class="btn btn-primary"><?php echo htmlspecialchars($_SESSION["login"]); ?></span>
                <a href="deconnexion.php" class="small-text">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="resume-container">
        <h2 class="resume-title">Résumé de vos choix de voyage</h2>
       
        <?php if (!empty($donnees_utilisateur)): ?>
            <div class="resume-section">
                <h3>Informations personnelles</h3>
                <div class="resume-item">
                    <span class="resume-label">Nom d'utilisateur :</span>
                    <span class="resume-value"><?php echo htmlspecialchars($_SESSION["login"]); ?></span>
                </div>
                <div class="resume-item">
                    <span class="resume-label">Email :</span>
                    <span class="resume-value"><?php echo htmlspecialchars($donnees_utilisateur['email'] ?? 'Non spécifié'); ?></span>
                </div>
                <div class="resume-item">
                    <span class="resume-label">Date de sélection :</span>
                    <span class="resume-value"><?php echo htmlspecialchars($donnees_utilisateur['date'] ?? 'Non disponible'); ?></span>
                </div>
            </div>

            <div class="resume-section">
                <h3>Vos préférences de voyage</h3>
                <?php if (!empty($donnees_utilisateur['choix'])): ?>
                    <?php foreach ($donnees_utilisateur['choix'] as $index => $choix): ?>
                        <div class="resume-item">
                            <span class="resume-label">Étape <?php echo $index + 1; ?> :</span>
                            <span class="resume-value"><?php echo htmlspecialchars($traductions[$choix] ?? $choix); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun choix enregistré pour le moment.</p>
                <?php endif; ?>
            </div>

            <form action="reservation.php" method="post" class="resume-section">
                <h3>Options supplémentaires</h3>
               
                <div class="resume-item">
                    <label for="bagages" class="resume-label">Nombre de bagages :</label>
                    <select id="bagages" name="bagages" class="resume-value" style="padding: 5px;">
                        <option value="1">1 bagage</option>
                        <option value="2">2 bagages</option>
                        <option value="3">3 bagages</option>
                        <option value="plus">Plus de 3 bagages</option>
                    </select>
                </div>
               
                <div class="resume-item">
                    <span class="resume-label">Options :</span>
                    <div class="resume-value" style="display: flex; flex-direction: column;">
                        <label><input type="checkbox" name="options[]" value="assurance"> Assurance voyage</label>
                        <label><input type="checkbox" name="options[]" value="transfert"> Transfert aéroport</label>
                        <label><input type="checkbox" name="options[]" value="annulation"> Annulation gratuite</label>
                    </div>
                </div>
               
                <div class="resume-item">
                    <span class="resume-label">Commentaires :</span>
                    <textarea name="commentaires" class="resume-value" style="padding: 5px; width: 200px;" rows="3"></textarea>
                </div>
            </form>

            <div class="form-actions">
                <a href="quiz.php" class="btn btn-secondary">Modifier mes choix</a>
                <button type="submit" class="btn btn-primary">Confirmer et réserver</button>
            </div>
        <?php else: ?>
            <p>Vous n'avez pas encore complété le quiz. <a href="quiz.php">Commencer le quiz</a></p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel. Tous droits réservés.</p>
    </footer>
</body>
</html>