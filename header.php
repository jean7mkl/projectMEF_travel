<?php
session_start();
?>

<header>
    <div class="header-container">
        <div class="logo-title">
            <a href="projet.html" class="logo-link">
                <img src="Logo.png" alt="Logo Travel4all" class="logo">
            </a>
            <h1>WHERE2GO</h1>
        </div>
        
        <nav>
            <a href="projet.html" class="btn-nav">Notre Accueil</a>
            <a href="pagequizz.html" class="btn-nav">Découvrir notre concept</a>
            <a href="présprojet.html" class="btn-nav">Qui sommes-nous?</a>
        </nav>

        <div class="header-auth">
            <?php if (isset($_SESSION['utilisateur'])) : ?>
                <!-- Bouton "Client" -->
                <a href="moncompte.php" class="btn btn-primary">Client</a>
            <?php else : ?>
                <!-- Boutons pour les non-connectés -->
                <a href="connecter.html" class="btn btn-primary">Se connecter</a>
                <p class="small-text">Nouveau client ? <a href="inscription.html">S'inscrire</a></p>
            <?php endif; ?>
        </div>
    </div>
</header>
