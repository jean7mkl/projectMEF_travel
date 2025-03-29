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
                <a href="connecter.php" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.php">S'inscrire</a></p>
            </div>
        </div>
    </header>
    <div class="text"><b><p> -Vous ne savez pas où partir ?
        Mais vous avez des envies bien précises ?</p> <p>        -Vous rêvez d’une soirée entre amis sur une plage exotique ? D’une aventure en pleine nature, loin de la foule ? Ou de vacances en famille à la montagne, à la recherche d’air pur et de paysages grandioses ?</p>
         <p>-Ne cherchez plus ! Notre quiz personnalisé vous aide à trouver la destination parfaite en fonction de vos préférences et de vos envies.  </p>                                             <br> -Répondez à quelques questions et laissez-nous vous guider vers votre voyage idéal !
    </div>
</b>

   <center><div class="container">
        <!-- Section du Quiz -->
        <div class="offers">
            <div class="offer"><img src="https://www.fodors.com/wp-content/uploads/2019/01/Maldives2.gif" alt="Maldives">
                <h2 id="Nos-offres">NOTRE QUIZ</h2>
                <a href="quiz.php" class="lienquiz">Démarrer le Quiz</a>
            </div>
        </div></center> 

    </div>
    <footer><p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel.<br> Tous droits réservés.</p> 
    </footer>
</body>
</html>
