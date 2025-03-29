const questions = {
    start: {
        question: "Préférez-vous voyager :",
        answers: {
            "En famille": "famille",
            "Entre amis": "amis",
            "En amoureux": "amoureux"
        }
    },
    famille: {
        question: "Plutôt :",
        answers: {
            "Détente à la montagne": "montagne",
            "Vacances en ville": "ville-famille",
            "Vacances à la plage": "plage-famille"
        }
    },
    result: {
        question: "Merci d'avoir répondu ! Cliquez pour réserver.",
        answers: {
            "Réserver votre voyage": "reservation.php"
        }
    }
};

let currentStep = "start";

function loadQuestion() {
    const quiz = document.getElementById("quiz");
    const questionEl = document.getElementById("question");
    const choicesEl = document.getElementById("choices");
    const step = questions[currentStep];

    questionEl.innerText = step.question;
    choicesEl.innerHTML = "";

    Object.keys(step.answers).forEach(answerText => {
        const answerValue = step.answers[answerText];
        const button = document.createElement("div");
        button.classList.add("choice");
        button.innerText = answerText;
        button.onclick = () => {
            if (answerValue === "reservation.php") {
                window.location.href = answerValue;
            } else {
                currentStep = answerValue;
                loadQuestion();
            }
        };
        choicesEl.appendChild(button);
    });
}

document.addEventListener("DOMContentLoaded", loadQuestion);
