const questions = Array.from(document.querySelectorAll('.question-wrap'));
const navigationButtons = document.querySelector(".navigation-buttons");
const examProcessSectionNav = document.querySelector(".exam-process-section-nav");
const attemptId = document.getElementById("attempt_id")?.textContent;
const shouldRunScript = document.getElementById("load_script");

let currentQuestion = 1;
let checked_answers = [];

navigationButtons?.addEventListener("click", function(e) {
    let mainEl = e.target;

    if (!mainEl.classList.contains('nav-btn')) return;

    switch (mainEl.textContent) {
        case "Sljedeće pitanje":
            currentQuestion = loadQuestionDivs().getAttribute("data-question");
            break;
        case "Prethodno pitanje":
            currentQuestion = loadQuestionDivs().getAttribute("data-question");
            break;
        default: 0
            break;
    }
});

examProcessSectionNav?.addEventListener("click", function(e) {
    let mainEl = e.target;

    if (!mainEl.classList.contains("exam-process-nav-btn")) return;
    currentQuestion = mainEl.textContent;
});

const loadQuestionDivs = function() {
    const questions = Array.from(document.querySelectorAll(".question-wrap"));
    const currentQuestion = questions.filter(q => q.style.display !== 'none');
    return currentQuestion[0];
}

const loadCheckedAnswer = function() {
    const answers = Array.from(document.querySelectorAll(".answers-wrap input"));
    return answers.filter(a => a.checked);
}

const updateState = async function() {
    try {

        const answers = loadCheckedAnswer();
        const freshCheckedAnswers = answers.map(el => el.id);

        const request = await axios.patch(`/ispiti/pokusaj/${attemptId}/spremi-stanje`, {
            current_question: currentQuestion,
            checked_answers: freshCheckedAnswers
        }, {
            withCredentials: true
        });

        if (request.status === 200) {
            console.log(request.data);
        }
    } catch (error) {
        console.error(error);
    }
}


if (shouldRunScript) {
    setInterval(() => {
        updateState();
    }, 10000);
}
