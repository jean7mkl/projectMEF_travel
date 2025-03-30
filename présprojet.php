<?php
session_start();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="sitedevoyage.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <?php if (isset($_SESSION['login'])) : ?>
                <!-- Bouton "Client" -->
                <a href="moncompte.php" class="btn btn-primary"><?php echo htmlspecialchars($_SESSION["login"]); ?></a>
                <a href="déconnexion.php" class="btn btn-primary">Se déconnecter</a>
            <?php else : ?>
                <!-- Boutons pour les non-connectés -->
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            <?php endif; ?>
        </div>
        </div>
    </header>  
    

    <video width="100%" autoplay loop muted>
        <source src="photo/video.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la lecture de vidéos.
    </video>    

    <div class="content2">
        <div class="text2">
            <h1>Voyager dans le monde requiert un service ultra personnalisé</h1>
            <p>Créée en 2024, Where2go est une agence de voyage innovante qui simplifie l'organisation de séjours en proposant une expérience entièrement personnalisée. Contrairement aux agences traditionnelles qui offrent des itinéraires standards, nous utilisons un quiz intelligent pour créer un voyage qui vous correspond parfaitement.

                Notre équipe d’une vingtaine d’experts analyse vos réponses pour sélectionner les destinations, hébergements et activités les plus adaptés à votre style, votre budget et vos envies.
                Pourquoi choisir Where2go ?</br>
                
                    Une expérience 100 % sur mesure : Chaque voyage est conçu selon votre profil et vos préférences.</br>
                    Un gain de temps considérable : Plus besoin de comparer des centaines d’offres, nous trouvons l’itinéraire idéal pour vous.</br>
                    Un service clé en main : Nous gérons tout, des vols aux excursions, pour un voyage sans stress.</br>
                    Des experts passionnés : Notre équipe sélectionne soigneusement chaque élément de votre séjour.</br>
                
                Avec Where2go, </br>laissez-vous guider et partez l’esprit léger. Faites le quiz dès maintenant et découvrez votre prochaine destination !</p>
            <a href="#" class="btnpres">Prendre contact avec nous</a>
        </div>
        <div class="image2-right">
            <img src="photo/pexels-gantas-4484243.jpg" alt="Personne en costume">
        </div>
    </div>

    <div class="image2-bottom">
        <img src="photo/pexels-pixabay-62623.jpg" alt="Vue depuis un avion">
        <div class="inspire2-text">
            <h2>Inspirez-vous</h2>
            <p>Retrouvez-nous sur les réseaux sociaux pour suivre notre actualité et vous inspirer sur les plus belles destinations partout dans le monde.</p>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p> 
    </footer>
</body>

</html>