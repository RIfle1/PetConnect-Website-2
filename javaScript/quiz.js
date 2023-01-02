const data = [
    {
        question: "Quel est l'animal qui pollue le plus ?",
        a: "Boeuf",
        b: "Chien",
        c: "Aigle",
        d: "Dauphin",
        correct: "a",
    },
    {
        question: "Quel est le budget annuel moyen pour un chien ?",
        a: "50-100€",
        b: "200-400€",
        c: "400-1000€",
        d: "1000-1500€",
        correct: "d",
    },

    {
        question: "La truffe d’un chien est aussi unique que les empreintes digitales d’un humain. Vrai ou Faux ?",
        a: "Vrai",
        b: "Faux",
        correct: "a",
    },

    {
        question: "Les orages sont nocifs pour les oreilles des chiens. Vrai ou Faux ?",
        a: "Vrai",
        b: "Faux",
        correct: "a",
    },


    {
        question: "Combien de races de chien existent dans le monde ?",
        a: "170",
        b: "330",
        c: "460",
        d: "810",
        correct: "b",
    },


    {
        question: "Les chiens ont un odorat combien de fois plus developpé que l'homme ?",
        a: "10",
        b: "100",
        c: "1000",
        d: "10000",
        correct: "d",
    },


    {
        question: "Quel est le gaz le plus polluant ?",
        a: "Le dioxyde de carbone (CO2)",
        b: "Le méthane (CH4)",
        c: "Le protoxyde d’azote (N2O)",
        d: "L’ozone (O3)",
        correct: "a",
    },


    {
        question: "Combien de chien sont perdus durant 1 année ?",
        a: "10 000",
        b: "20 000",
        c: "30 000",
        d: "40 000",
        correct: "c",
    },


    {
        question: "Quel est le rythme cardiaque normal d'un chien adulte",
        a: "20 bpm",
        b: "40 bpm",
        c: "50 bpm",
        d: "60 bpm",
        correct: "d",
    },


    {
        question: "Combien de dents ont les chiens",
        a: "24",
        b: "28",
        c: "36",
        d: "42",
        correct: "d",
    },
]


const quiz = document.getElementById("quiz")
const answerEls = document.querySelectorAll(".answer")
const questionEl = document.getElementById("question")
const optionA = document.getElementById("optionA")
const optionB = document.getElementById("optionB")
const optionC = document.getElementById("optionC")
const optionD = document.getElementById("optionD")
const option4 = document.getElementById("option4")
const page = document.getElementById("page")


const submitBtn = document.getElementById("submit")

let currentQuiz = 0
let score = 0


loadQuiz()

function loadQuiz() {
    deselectAnswer()

    const currentQuizData = data[currentQuiz]
    questionEl.innerText = currentQuizData.question
    optionA.innerText = currentQuizData.a
    optionB.innerText = currentQuizData.b
    optionC.innerText = currentQuizData.c
    optionD.innerText = currentQuizData.d
    page.innerHTML = `<p>${currentQuiz + 1}/${data.length}  </p>  `
    if (optionD.innerText == 'undefined') {
        option3.hidden = true;
        option4.hidden = true;
    } else {
        option3.hidden = false;
        option4.hidden = false;
    }


}

function deselectAnswer() {
    answerEls.forEach((answerEl) => (
        answerEl.checked = false
    ))
}


function getSelect() {
    let answer

    answerEls.forEach((answerEl) => {
        if (answerEl.checked) {
            answer = answerEl.id
        }
    })

    return answer

}



submitBtn.addEventListener("click", () => {
    const answer = getSelect()

    if (answer) {
        if (answer === data[currentQuiz].correct) {
            score++
        }
        currentQuiz++

        if (currentQuiz < data.length) {
            loadQuiz()
        }
        else {
            quiz.innerHTML = `
            <h2>Vous avez répondu à ${score}/${data.length} correctement </h2>

            <button onclick="location.reload()">Refaire le quiz</button>
            `
        }

    }

})