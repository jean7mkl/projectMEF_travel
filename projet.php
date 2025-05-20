<?php
session_start();
$username = $_SESSION['username'] ?? null;
?>




<?php include 'header.php'; ?>




    <div class="hero">1~Découvrez notre concept futuriste !
    <div class="subtitle"><br/><br/><br/><br/>2~On vous trouve le voyage dont vous avez tant révés !</div></div>
    <p>
    <center>
    <div class="container">
        <!-- Section du Quiz -->
        <div class="offers">
            <div class="offer"><img src="https://www.fodors.com/wp-content/uploads/2019/01/Maldives2.gif" alt="Maldives">
                <h2 id="Nos-offres">NOTRE QUIZ</h2>
                <a href="pagequizz.php" class="lienquiz">Démarrer le Quiz</a>
            </div>
        </div>

    </div>
</center>
</p>

<?php include 'footer.php'; ?>

</body>
</html>
