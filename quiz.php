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
</br></br></br>
    <center>
        <div class="quiz-container" id="quiz">
            <div class="question" id="question">Préférez-vous voyager :</div>
            <div class="choices" id="choices"></div>
            <div class="back" id="back" onclick="goBack()">Retour</div>
            <div class="restart" id="restart" onclick="restartQuiz()">Recommencer le quiz</div>
        </div>
    </center>

    <script>
        const questions = {
            start: { question: "Préférez-vous voyager :", answers: { "En famille": "famille", "Entre amis": "amis", "En amoureux": "amoureux" } },
            famille: { question: "Plutôt :", answers: { "Détente à la montagne": "montagne", "Vacances en ville": "ville-famille", "Vacances à la plage": "plage-famille" } },
            montagne: { question: "Été ou hiver ?", answers: { "Été": "ete-montagne", "Hiver": "hiver-montagne" } },
            "ete-montagne": { question: "Pourquoi pas Chamonix en été ?", answers: { "Oui !": "result", "Non, autre choix": "montagne" } },
            "hiver-montagne": { question: "Pourquoi pas Megève en hiver ?", answers: { "Oui !": "result", "Non, autre choix": "montagne" } },
            "ville-famille": { question: "Pourquoi pas New York ?", answers: { "Oui !": "result", "Non, autre choix": "famille" } },
            "plage-famille": { question: "Plutôt où ?", answers: { "Les Caraïbes": "result", "La Côte d'Azur": "result", "Non, autre choix": "famille" } },
            amis: { question: "Préférez-vous :", answers: { "Visite en ville": "ville-amis", "Fiesta à la montagne": "courchevel", "Fête à la plage": "barcelone" } },
            courchevel: { question: "Prêt pour Courchevel ?", answers: { "Oui, à fond !": "result", "Non, autre choix": "amis" } },
            barcelone: { question: "Barcelone, ça vous tente ?", answers: { "Oui, soleil et fiesta !": "result", "Non, autre choix": "amis" } },
            amoureux: { question: "Plutôt :", answers: { "Plage aux Maldives": "maldives", "Ski en Suisse": "suisse" } },
            maldives: { question: "Les Maldives, ça vous tente ?", answers: { "Oui, paradisiaque !": "result", "Non, autre choix": "amoureux" } },
            suisse: { question: "Le ski en Suisse ?", answers: { "Oui, trop bien !": "result", "Non, autre choix": "amoureux" } },
            result: { question: "Merci d'avoir répondu ! Bonnes vacances ! 😊", answers: { "Recommencer le quiz": "start" } }
        };

        let currentStep = "start";
        let history = [];
        let choixUtilisateur = [];

        function enregistrerChoix(choix) {
            choixUtilisateur.push(choix);

            if (choix === "result") {
                fetch("choixutilisateurs.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ choix: choixUtilisateur })
                })
                .then(response => response.json())
                .then(data => console.log("✅ Réponse du serveur :", data))
                .catch(error => console.error("❌ Erreur d'envoi :", error));

                choixUtilisateur = [];
            }
        }

        function loadQuestion() {
            const quiz = document.getElementById("quiz");
            const questionEl = document.getElementById("question");
            const choicesEl = document.getElementById("choices");
            const backBtn = document.getElementById("back");
            const restartBtn = document.getElementById("restart");

            const step = questions[currentStep];

            questionEl.innerText = step.question;
            choicesEl.innerHTML = "";
            restartBtn.style.display = "none";
            backBtn.style.display = history.length > 0 ? "block" : "none";

            if (currentStep === "result") {
                restartBtn.style.display = "block";
                return;
            }

            Object.keys(step.answers).forEach(answerText => {
                const answerValue = step.answers[answerText];
                const button = document.createElement("div");
                button.classList.add("choice");
                button.innerText = answerText;
                button.onclick = () => {
                    history.push(currentStep);
                    currentStep = answerValue;
                    enregistrerChoix(answerText);
                    loadQuestion();
                };
                choicesEl.appendChild(button);
            });

            quiz.classList.remove("show");
            setTimeout(() => quiz.classList.add("show"), 100);
        }

        function goBack() {
            if (history.length > 0) {
                currentStep = history.pop();
                loadQuestion();
            }
        }

        function restartQuiz() {
            currentStep = "start";
            history = [];
            choixUtilisateur = [];
            loadQuestion();
        }

        loadQuestion();
    </script>
    </br></br></br>

    <footer>
        <p>&copy; 2025 Agence de Voyage de Leo Bouabdallah, Thomas Ribeiro, Jean Moukarzel. Tous droits réservés.</p> 
    </footer>
</body>
</html>
