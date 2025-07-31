"use strict"


const addQuestionBtn = document.querySelector(".add_question");
const questionsDiv = document.querySelector("#questions");
const examOptions = document.querySelector('.save_exam');
const examId = parseInt(document.querySelector('#exam-id')?.textContent);
let numOfQuestions = 0;


addQuestionBtn?.addEventListener("click", () => {
    addQuestionFunc(questionsDiv);
    numOfQuestions++;


    if (numOfQuestions >= 2) {
        examOptions.style = "display:block;";
    }
});


const addQuestionFunc = function(appendEl) {

    const questionDivHolder = document.createElement("div");
    questionDivHolder.classList.add(`question-div`);

    const questionNumber = document.createElement('a');
    questionNumber.classList.add('question_title')
    questionNumber.id = `id-${Date.now()}`;
    questionDivHolder.appendChild(questionNumber);

    const questionInput = document.createElement("textarea");
    questionInput.cols = 100;
    questionInput.rows = 5;
    questionInput.name = "question";
    questionInput.classList.add("question");
    questionInput.setAttribute("spellcheck", "false");
    questionInput.placeholder = "Unesite pitanje";

    const delQuestionBtn = document.createElement("button");
    delQuestionBtn.textContent = "Obriši pitanje";
    delQuestionBtn.classList.add("del_question");

    const addAnswerBtn = document.createElement("button");
    addAnswerBtn.textContent = "Dodaj odgovor";
    addAnswerBtn.classList.add("add_answer");

    questionDivHolder.appendChild(questionInput);
    questionDivHolder.appendChild(addAnswerBtn);
    questionDivHolder.appendChild(delQuestionBtn);
    appendEl.appendChild(questionDivHolder);

    questionDivHolder.addEventListener("click", (e) => {
        let mainEl = e.target;
        if (mainEl.classList.contains('add_answer')) {

        const answerDiv = document.createElement("div");
        answerDiv.classList.add("answer_div");
        mainEl.parentElement.appendChild(answerDiv);

        const answerInput = document.createElement("input");
        answerInput.name = "answer";
        answerInput.autocomplete = "off";
        answerInput.classList.add(`answer`);

        const isCorrectDiv = document.createElement("div");
        isCorrectDiv.classList.add("is_correct_div");

        const isCorrectLabel = document.createElement("label");
        isCorrectLabel.textContent = "Točan?";

        const isCorrectInput = document.createElement("input");
        isCorrectInput.type = "radio";
        isCorrectInput.name = "is_correct";
        isCorrectInput.classList.add('is_correct');

        isCorrectDiv.appendChild(isCorrectLabel);
        isCorrectDiv.appendChild(isCorrectInput);

        const deleteAnswer = document.createElement("button");
        deleteAnswer.classList.add("delete_answer");
        deleteAnswer.textContent = "Obriši odgovor";

        answerDiv.appendChild(answerInput);
        answerDiv.appendChild(isCorrectDiv);
        answerDiv.appendChild(deleteAnswer);
    }

    if (mainEl.classList.contains('del_question')) {
        let parentDiv = mainEl.parentElement;

        const confirmation = prompt("Želite li obrisati ovo pitanje? Upisati 'Da' za potvrdu.");

        if (!confirmation) return;

        const transformToLower = confirmation.toLowerCase();

        if (transformToLower === 'da') {
            numOfQuestions--;
            parentDiv.remove();
        }
        if (numOfQuestions < 2) {
            examOptions.style = "display:none;";
        }
    }

    if (mainEl.classList.contains('delete_answer')) {
        let parentDiv = mainEl.parentElement;
        const confirmation = prompt("Želite li obrisati ovaj odgovor? Upisati 'Da' za potvrdu.");

        if (!confirmation) return;

        const transformToLower = confirmation.toLowerCase();

        if (transformToLower === 'da') {
            parentDiv.remove();
        }
    }

    let correctAnswer;
    if (mainEl.classList.contains('is_correct')) {

        const answerElementHolder = mainEl.parentElement.parentElement;
        const questionElementHolder = mainEl.parentElement.parentElement.parentElement;
        const answerInput = answerElementHolder.querySelector('.answer');
        answerInput.classList.add('correct');
        correctAnswer = answerInput;
        correctAnswer.style.backgroundColor = 'lime';

        const answerInputs = Array.from(questionElementHolder.querySelectorAll('.answer'));


        for(let i = 0 ; i < answerInputs.length ; i++)
        {
            if (answerInputs[i] === correctAnswer) continue;
            answerInputs[i].classList.remove('correct');
            answerInputs[i].style.backgroundColor = '#fff';
        }
    }
    });
}

let questions = [];
examOptions?.addEventListener("click", () => {

    let hasError = false;
    const questionDivs = Array.from(document.querySelectorAll(".question-div"));
    questionDivs.forEach((div, _index) => {

        const question = div.querySelector('.question');
        const questionTitle = div.querySelector(".question_title").id;
        const answersDivs = Array.from(div.querySelectorAll(".answer_div .answer"));
        const answers = {};

        for(let i = 0 ; i < answersDivs.length ; i++)
        {
            answers[i + 1] = answersDivs[i].value;
            if (answersDivs[i].classList.contains('correct'))
            {
                answers.is_correct = answersDivs[i].value;
            } else continue;

        }

        const questionObject = {
            examId: examId,
            questionId: questionTitle,
            questionValue: question.value,
            answers: answers
        };

        questions.push(questionObject);
    });

//////////////////////////////////////////VALIDACIJA/////////////////////////////////////////////////////

    for (const question of questions)
    {
        const el = document.querySelector(`#${question.questionId}`).parentElement;

        // Pitanje je prazno
        if (!question.questionValue)
        {
            hasError = true;
            signalError(el);
            handleScrollBehavior(el);
            questions = [];
            break;
        }
        const answers = Array.from(el.querySelectorAll(".answer_div .answer"));

        // Nema odgovora ili je broj odgovora manji od 2
        if (!answers.length || answers.length < 2)
        {
            hasError = true;
            signalError(el);
            handleScrollBehavior(el);
            questions = [];
            break;
        }

        // Ima praznih odgovora
        for (const answer of answers)
        {
            if (!answer.value) {
                hasError = true;
                signalEmptyAnswers(el);
                handleScrollBehavior(el);
                questions = [];
                break;
            }
        }

        const correctAnswer = el.querySelector(".answer_div .correct");
        const correctAnswerObj = question.answers.is_correct;

        // Nije označen točan odgovor
        if (!correctAnswer && !correctAnswerObj)
        {
            hasError = true;
            signalError(el);
            handleScrollBehavior(el);
            questions = [];
            break;
        }
    }

    if (hasError)
    {
        return;
    }

    saveQuestions({questions});


});


////////////////////////////////////////////////////////////////////////////////////////////


// Slanje AJAX requesta
const saveQuestions = async function (data) {
    try {
        const request = await axios.post(`/nastavnik/provjera-znanja/${examId}/spremi-pitanja`,
        data,
        {
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
        withCredentials: true,
        });
        if (request.status === 200) {
            console.log(request.data);
        }

    } catch (error) {
        console.error("Error: ", error);
    }
};



const handleScrollBehavior = function(el) {
    window.scrollTo(el.getBoundingClientRect().x, el.getBoundingClientRect().y,{
    behavior: 'smooth',
    });
}

const signalError = function(el) {
    el.style.backgroundColor = 'rgb(255, 86, 86)';
    setTimeout(() => {
        el.style.backgroundColor = '#a4f8ce4d';
    }, 1000);
}

const signalEmptyAnswers = function(questionDiv) {
    const answerDivs = Array.from(questionDiv.querySelectorAll('.answer_div'));
    for(let i = 0 ; i < answerDivs.length ; i++)
    {
        const answerInput = answerDivs[i].querySelector('.answer');
        if (!answerInput.value) {
            answerInput.style.backgroundColor = 'rgb(255, 86, 86)';
        }
    }

    setTimeout(() => {
        for(let i = 0 ; i < answerDivs.length ; i++)
        {
            const answerInput = answerDivs[i].querySelector('.answer');
            if (answerInput.style.backgroundColor === 'rgb(255, 86, 86)') {
                answerInput.style.backgroundColor = '#fff';
            }
        }
    }, 1000);
}
