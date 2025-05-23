<?php
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) { 
    header("Location: connecter.php");
    exit();
}

// Sécurise le nom de l'utilisateur contre les failles XSS
$username = htmlspecialchars($_SESSION['login']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mon compte</title>
   <link rel="stylesheet" href="sitedevoyage.css">
</head>

<body>
<?php include 'header.php'; ?>


   <main>
       <section class="compte2-section">
           <h1>Bienvenue, <u><?php echo $username; ?></u> !</h1>

           <div class="compte2-buttons">
               <a href="voyage.php" class="compte2-button">
                   <b>Mon prochain voyage</b>
                   <span>Consultez et gérez vos voyages en cours ou à venir.</span>
               </a>

               <a href="historique.php" class="compte2-button">
                   <b>Historique de commandes</b>
                   <span>Retrouvez tous vos voyages passés.</span>
               </a>

               <a href="profil.php" class="compte2-button">
                   <b>Mon profil</b>
                   <span>Modifiez vos informations personnelles et préférences.</span>
               </a>

               <a href="formulaire.php" class="compte2-button">
                   <b>Refaire le quiz ?</b>
                   <span> De nouvelles envies de départs, sans idées concrètes? Refaites notre quiz...</span>
               </a>

               <a href="déconnexion.php" class="compte2-button btn3-danger">
                   <b>Se déconnecter</b>
                   <span>Terminez votre session en toute sécurité.</span>
               </a>


               
               <?php if (isset($_SESSION['role'])):
                    if( $_SESSION['role'] == 'admin') :
                ?>

                 <a href="admin_dashboard.php" class="compte2-button admin-button">
                <b>Espace administrateur</b>
                <span>Gérer les utilisateurs, les statuts spéciaux et les restrictions.</span>
                </a>
                <?php endif; ?>
                <?php endif; ?>

           </div>
       </section>
   </main>

   <?php include 'footer.php'; ?>

</body>
</html>
