const questions = Array.from(document.querySelectorAll('.question-wrap'));
const navigationButtons = document.querySelector(".navigation-buttons");
const examProcessSectionNav = document.querySelector(".exam-process-section-nav");
const attemptId = document.getElementById("attempt_id")?.textContent;
const shouldRunScript = document.getElementById("load_script");
const examId = parseInt(document.getElementById("exam_id")?.textContent);
const currentQuestionId = parseInt(document.getElementById("current_question")?.textContent);


let currentQuestion = currentQuestionId || 1;
let checked_answers = [];

navigationButtons?.addEventListener("click", function(e) {
    let mainEl = e.target;

    if (!mainEl.classList.contains('nav-btn')) return;

    currentQuestion = loadQuestionDivs();
});

examProcessSectionNav?.addEventListener("click", function(e) {
    let mainEl = e.target;

    if (!mainEl.classList.contains("exam-process-nav-btn")) return;
    currentQuestion = mainEl.textContent;
});

const loadQuestionDivs = function() {
    const questions = Array.from(document.querySelectorAll(".question-wrap"));
    const currentQuestion = questions.filter(q => q.style.display !== 'none');

    return currentQuestion[0].getAttribute("data-question");
}

const loadCheckedAnswer = function() {
    const answers = Array.from(document.querySelectorAll(".answers-wrap input"));
    return answers.filter(a => a.checked);
}

const loadCheckedNavButtons = function() {
    const navBtns = Array.from(document.querySelectorAll(".exam-process-nav-btn"));
    return navBtns.map((b) => {
        if (b.classList.contains("checked")) {
            return b.textContent;
        }
    });
}

const updateState = async function() {
    try {

        const answers = loadCheckedAnswer();
        const navBtns = loadCheckedNavButtons();

        const freshCheckedAnswers = answers.map(el => el.id);

        const request = await axios.patch(`/ispiti/pokusaj/${attemptId}/ispit/${examId}/spremi-stanje`, {
            current_question: currentQuestion,
            checked_answers: freshCheckedAnswers,
            nav_btns: navBtns
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

questions.forEach(q => {
    q.addEventListener("click", function(e) {
        let mainEl = e.target;
        if (!mainEl.classList.contains('answer')) return;

        const questionParentEl = mainEl.parentElement.parentElement.parentElement.getAttribute("data-question");
        const navBtns = Array.from(document.querySelectorAll(".exam-process-nav-btn"));

        const btnToChange = navBtns?.filter(btn => parseInt(btn.textContent) === parseInt(questionParentEl))[0];
        btnToChange?.classList.add("checked");

        if(btnToChange) {
            btnToChange.style.backgroundColor = '#3ea87f';
        }
    })
})
