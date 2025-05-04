<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="sitedevoyage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Voyage</title>
    <style>
        .quiz-container {
            background: #FFF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        .question {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .choices {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .choice {
            background: #F5E1C8;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .choice:hover { background: #E6D0B5; }
        .back, .restart {
            background: #B5651D;
            color: white;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            display: none;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

<br><br><br>
<center>
    <div class="quiz-container" id="quiz">
        <div class="question" id="question">Chargement...</div>
        <div class="choices" id="choices"></div>
        <div class="back" id="back">Retour</div>
        <div class="restart" id="restart">Recommencer le quiz</div>
    </div>
</center>
<br><br><br>

<script src="quiz.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>
