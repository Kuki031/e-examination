"use strict"


const addQuestionBtn = document.querySelector(".add_question");
const questionsDiv = document.querySelector("#questions");
const examOptions = document.querySelector('.save_exam');
let numOfQuestions = 0;
let inMemoryQuestionValidators = [];

addQuestionBtn?.addEventListener("click", () => {
    addQuestionFunc(questionsDiv);
    numOfQuestions++;


    if (numOfQuestions >= 2) {
        examOptions.style = "display:block;";
    }

});


const addQuestionFunc = function(appendEl) {

    const questionDivHolder = document.createElement("div");
    questionDivHolder.classList.add(`question_div`);
    questionDivHolder.style = "display:flex;flex-wrap:wrap;flex-direction:column;gap:5px;margin:auto 20px;background-color:lightgray;padding:10px;"

    const questionNumber = document.createElement('a');
    questionNumber.textContent = `Pitanje #${Date.now()}`;
    questionNumber.id = Date.now();
    questionNumber.style = "text-decoration:none;"
    questionDivHolder.appendChild(questionNumber);

    const questionInput = document.createElement("textarea");
    questionInput.cols = 60;
    questionInput.rows = 5;
    questionInput.name = "question";
    questionInput.classList.add("question");
    questionInput.placeholder = "Unesite pitanje";

    const delQuestionBtn = document.createElement("button");
    delQuestionBtn.textContent = "Obriši pitanje";
    delQuestionBtn.classList.add("del_question");

    const addAnswerBtn = document.createElement("button");
    addAnswerBtn.textContent = "Dodaj odgovor";
    addAnswerBtn.classList.add("add_answer");

    questionDivHolder.appendChild(questionInput);
    questionDivHolder.appendChild(delQuestionBtn);
    questionDivHolder.appendChild(addAnswerBtn);
    appendEl.appendChild(questionDivHolder);

    questionDivHolder.addEventListener("click", (e) => {
        let mainEl = e.target;
        if (mainEl.classList.contains('add_answer')) {

        const answerDiv = document.createElement("div");
        answerDiv.classList.add("answer_div");
        answerDiv.style = "display:flex;flex-wrap:wrap;flex-direction:row;align-items:center;justify-content:center;margin:auto;padding:10px;"
        mainEl.parentElement.appendChild(answerDiv);

        const answerInput = document.createElement("input");
        answerInput.name = "answer";
        answerInput.classList.add(`answer`);

        const isCorrectDiv = document.createElement("div");
        isCorrectDiv.style = "display:flex;flex-wrap:wrap;flex-direction:row;gap:5px;"

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
            answerInputs[i].style.backgroundColor = 'white';
        }
    }
    });
}

examOptions?.addEventListener("click", () => {
    const questionDivs = Array.from(document.querySelectorAll('.question_div'));
    questionDivs.forEach((div, _index) => {

        const question = div.querySelector('.question');
        const questionNumber = div.querySelector('a');

        if (!question.value) {
            return;
        }



        const answers = Array.from(div.querySelectorAll('.answer_div .answer'));

        if (!answers.length) {
            return;
        }

        if (answers.length < 2) {
            return;
        }

        let isEmptyAnswer = false;
        for(let i = 0 ; i < answers.length ; i++)
        {
            if (!answers[i].value) {
                isEmptyAnswer = true;
                break;
            }
        }
        if (isEmptyAnswer) {
            return;
        };

        const answerObj = {};
        answers.forEach((a, i) => {
            answerObj[i + 1] = a.value;
            if (a.classList.contains('correct')) {
                answerObj['correct_answer'] = a.value;
            }

        })

        const matchKey = Object.keys(answerObj).includes("correct_answer", 0);
        if (!matchKey) {
            return;
        }


        const answersJSON = JSON.stringify(answerObj);
        const totalNumberOfQuestions = questionDivs.length;

        //Testni exam id
        const examId = 1;
        console.log(`question = ${question.value}\nanswers = ${answersJSON}\ntotal num of questions: ${totalNumberOfQuestions}`);

        /*
        Features:
        - Dodat mogucnost stavljanja slike u pitanje (i u backendu)
        - Local storage kao draft
        - Control flow (ako ima neki error, ne slati ajax request)
        */

        /*
        Improvements:
        - Ljepše boje
        - Tranzicija kod promjene boje errora
         */

        // Slanje AJAX requesta
        /*const request = async function () {
            try {
                const sendAxiosData = await axios({
                    method: "POST",
                    url: "http://localhost:8000/create-questions",
                    data: {
                        question: question.value,
                        answers: answersJSON,
                        exam_id: examId
                    }
                });
                console.log(sendAxiosData.data);
            } catch (error) {
                console.error("Request failed:", error.response?.data || error.message);
            }
            };
        request();*/

    });
});


const handleScrollBehavior = function(el) {
    window.scrollTo(el.getBoundingClientRect().x, el.getBoundingClientRect().y,{
    behavior: 'smooth',
    });
}

const signalError = function(el) {
    el.style.backgroundColor = 'red';
    setTimeout(() => {
        el.style.backgroundColor = 'lightgray';
    }, 1000);
}

const signalEmptyAnswers = function(questionDiv) {
    const answerDivs = Array.from(questionDiv.querySelectorAll('.answer_div'));
    for(let i = 0 ; i < answerDivs.length ; i++)
    {
        const answerInput = answerDivs[i].querySelector('.answer');
        if (!answerInput.value) {
            answerInput.style.backgroundColor = 'red';
        }
    }

    setTimeout(() => {
        for(let i = 0 ; i < answerDivs.length ; i++)
        {
            const answerInput = answerDivs[i].querySelector('.answer');
            if (answerInput.style.backgroundColor === 'red') {
                answerInput.style.backgroundColor = 'white';
            }
        }
    }, 1000);
}
