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
    montagne: {
        question: "Été ou hiver ?",
        answers: {
            "Été": "ete-montagne",
            "Hiver": "hiver-montagne"
        }
    },
    "ete-montagne": {
        question: "Pourquoi pas Chamonix en été ?",
        answers: {
            "Oui !": "result",
            "Non, autre choix": "montagne"
        }
    },
    "hiver-montagne": {
        question: "Pourquoi pas Megève en hiver ?",
        answers: {
            "Oui !": "result",
            "Non, autre choix": "montagne"
        }
    },
    "ville-famille": {
        question: "Pourquoi pas New York ?",
        answers: {
            "Oui !": "result",
            "Non, autre choix": "famille"
        }
    },
    "plage-famille": {
        question: "Plutôt où ?",
        answers: {
            "Les Caraïbes": "result",
            "La Côte d'Azur": "result",
            "Non, autre choix": "famille"
        }
    },
    amis: {
        question: "Préférez-vous :",
        answers: {
            "Visite en ville": "ville-amis",
            "Fiesta à la montagne": "courchevel",
            "Fête à la plage": "barcelone"
        }
    },
    courchevel: {
        question: "Prêt pour Courchevel ?",
        answers: {
            "Oui, à fond !": "result",
            "Non, autre choix": "amis"
        }
    },
    barcelone: {
        question: "Barcelone, ça vous tente ?",
        answers: {
            "Oui, soleil et fiesta !": "result",
            "Non, autre choix": "amis"
        }
    },
    amoureux: {
        question: "Plutôt :",
        answers: {
            "Plage aux Maldives": "maldives",
            "Ski en Suisse": "suisse"
        }
    },
    maldives: {
        question: "Les Maldives, ça vous tente ?",
        answers: {
            "Oui, paradisiaque !": "result",
            "Non, autre choix": "amoureux"
        }
    },
    suisse: {
        question: "Le ski en Suisse ?",
        answers: {
            "Oui, trop bien !": "result",
            "Non, autre choix": "amoureux"
        }
    },
    result: {
        question: "Votre destination est enregistrée ! Cliquez ci-dessous pour réserver.",
        answers: {
            "Réserver maintenant": "formulaire.php"
        }
    }
};

let currentStep = "start";
let history = [];
let choixUtilisateur = [];
let lastValidDestination = null;

// Liste des destinations valides
const destinationsValides = [
    "ete-montagne", "hiver-montagne", "ville-famille", "plage-famille",
    "ville-amis", "courchevel", "barcelone", "maldives", "suisse"
];

function enregistrerChoix(texte) {
    choixUtilisateur.push(texte);
    if (destinationsValides.includes(currentStep)) {
        lastValidDestination = currentStep;
    }

    if (currentStep === "result") {
        fetch("choixutilisateurs.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ choix: choixUtilisateur })
        }).then(r => r.json())
        .then(data => console.log("✅ Enregistré :", data))
        .catch(err => console.error("❌ Erreur :", err));

        choixUtilisateur = [];
    }
}

function loadQuestion() {
    const questionEl = document.getElementById("question");
    const choicesEl = document.getElementById("choices");
    const backBtn = document.getElementById("back");
    const restartBtn = document.getElementById("restart");

    const step = questions[currentStep];
    questionEl.innerText = step.question;
    choicesEl.innerHTML = "";
    backBtn.style.display = history.length > 0 ? "block" : "none";
    restartBtn.style.display = currentStep === "result" ? "block" : "none";

    Object.entries(step.answers).forEach(([text, value]) => {
        if (value === "formulaire.php" || currentStep === "result") {
            const link = document.createElement("a");
            const dest = encodeURIComponent(lastValidDestination || "non spécifiée");
            link.href = "formulaire.php?destination=" + dest;
            link.innerText = text;
            link.classList.add("choice");
            link.style.textDecoration = "none";
            choicesEl.appendChild(link);
        } else {
            const btn = document.createElement("div");
            btn.innerText = text;
            btn.classList.add("choice");
            btn.onclick = () => {
                history.push(currentStep);
                currentStep = value;
                enregistrerChoix(text);
                loadQuestion();
            };
            choicesEl.appendChild(btn);
        }
    });
}

document.addEventListener("DOMContentLoaded", loadQuestion);
document.getElementById("back").onclick = function () {
    if (history.length > 0) {
        currentStep = history.pop();
        loadQuestion();
    }
};
document.getElementById("restart").onclick = function () {
    currentStep = "start";
    history = [];
    choixUtilisateur = [];
    lastValidDestination = null;
    loadQuestion();
};
