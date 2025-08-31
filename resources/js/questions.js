import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR} from './constants';

"use strict"

const addQuestionBtn = document.querySelector(".add_question");
const questionsDiv = document.querySelector("#questions");
const examOptions = document.querySelector('.save_exam');
const examId = parseInt(document.querySelector('#exam-id')?.textContent);
let numOfQuestions = 0;


addQuestionBtn?.addEventListener("click", () => {
    addQuestionFunc(questionsDiv);
    numOfQuestions++;
    if (numOfQuestions >= 1)
    {
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


    const hasPictureMain = document.createElement("div");
    hasPictureMain.classList.add("has-picture-main");

    const hasPictureDiv = document.createElement("div");
    hasPictureDiv.classList.add("has-picture-holder");

    const hasPictureLabel = document.createElement("label");
    hasPictureLabel.textContent = "Slika?";

    const hasPictureCheckBox = document.createElement("input");
    hasPictureCheckBox.type = "checkbox";
    hasPictureCheckBox.classList.add("checkbox-input");

    hasPictureDiv.appendChild(hasPictureLabel);
    hasPictureDiv.appendChild(hasPictureCheckBox);

    hasPictureMain.appendChild(hasPictureDiv);

    const delQuestionBtn = document.createElement("button");
    delQuestionBtn.textContent = "Obriši pitanje";
    delQuestionBtn.classList.add("del_question");

    const addAnswerBtn = document.createElement("button");
    addAnswerBtn.textContent = "Dodaj odgovor";
    addAnswerBtn.classList.add("add_answer");

    questionDivHolder.appendChild(questionInput);
    questionDivHolder.appendChild(hasPictureMain);
    questionDivHolder.appendChild(addAnswerBtn);
    questionDivHolder.appendChild(delQuestionBtn);
    appendEl.appendChild(questionDivHolder);

    const divsScroll = Array.from(document.querySelectorAll(".question-div"));
    if (divsScroll) {
        handleScrollBehavior(divsScroll[divsScroll.length - 1]);
    }


    questionDivHolder.addEventListener("click", (e) => {
        let mainEl = e.target;

        if (mainEl.classList.contains('add_answer')) {

        const answerDiv = document.createElement("div");
        answerDiv.classList.add("answer_div");
        mainEl.parentElement.appendChild(answerDiv);

        const answerInput = document.createElement("input");
        answerInput.name = "answer";
        answerInput.autocomplete = "off";
        answerInput.spellcheck = false;
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

        const confirmation = confirm("Želite li obrisati ovo pitanje?");
        if (!confirmation) return;

        else if (confirmation) {
            numOfQuestions--;
            parentDiv.remove();
        }
        if (numOfQuestions < 1) {
            examOptions.style = "display:none;";
        }
    }

    if (mainEl.classList.contains('delete_answer')) {
        let parentDiv = mainEl.parentElement;
        const confirmation = confirm("Želite li obrisati ovaj odgovor?");
        if (!confirmation) return;

        else if (confirmation) {
            parentDiv.remove();
        }
    }

    if (mainEl.classList.contains('checkbox-input')) {

        let isChecked = mainEl.checked;
        if (isChecked)
        {
            createPictureSection(questionNumber.id, hasPictureMain);
        } else {
            const mainDiv = mainEl.parentElement.parentElement;
            const divToRemove = mainEl.parentElement.nextElementSibling.parentElement.parentElement.querySelector('.picture-div-holder');
            mainDiv.removeChild(divToRemove);
            return;
        }
    }

    if (mainEl.classList.contains("file-input"))
    {
        mainEl.addEventListener("change", (ev) => {
            const file = ev.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                mainEl.previousElementSibling.style.backgroundColor = 'inherit';
                mainEl.previousElementSibling.style.backgroundImage = `url('${event.target.result}')`;
            }

            reader.readAsDataURL(file);
        })

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
let isSaving = false;
examOptions?.addEventListener("click", (e) => {

    if (isSaving) return;


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

        if (!question.questionValue)
        {
            hasError = true;
            signalError(el, '#a4f8ce4d');
            handleScrollBehavior(el);
            setFlashMessage("Pitanje je prazno!", DANGER_COLOR);
            questions = [];
            break;
        }
        const answers = Array.from(el.querySelectorAll(".answer_div .answer"));

        if (!answers.length || answers.length < 2)
        {
            hasError = true;
            signalError(el, '#a4f8ce4d');
            handleScrollBehavior(el);
            setFlashMessage("Za ovo pitanje nema odgovora ili je broj odgovora manji od 2!", DANGER_COLOR);
            questions = [];
            break;
        }

        for (const answer of answers)
        {
            if (!answer.value) {
                hasError = true;
                signalEmptyAnswers(el);
                handleScrollBehavior(el);
                setFlashMessage("Ovo pitanje ima praznih odgovora!", DANGER_COLOR);
                questions = [];
                break;
            }
        }



        const isAnswerArrayUnique = areAnswersUnique(answers);
        if (!isAnswerArrayUnique)
        {
            hasError = true;
            signalError(el, '#a4f8ce4d');
            handleScrollBehavior(el);
            setFlashMessage("Za ovo pitanje postoje isti odgovori!", DANGER_COLOR);
            questions = [];
            break;
        }

        const correctAnswer = el.querySelector(".answer_div .correct");
        const correctAnswerObj = question.answers.is_correct;

        if (!correctAnswer && !correctAnswerObj)
        {
            hasError = true;
            signalError(el, '#a4f8ce4d');
            handleScrollBehavior(el);
            setFlashMessage("U ovom pitanju nije označen koji je točan odgovor!", DANGER_COLOR);
            questions = [];
            break;
        }
    }

    if (hasError)
    {
        return;
    }
    isSaving = true;
    saveQuestions();
});


////////////////////////////////////////////////////////////////////////////////////////////


// Slanje AJAX requesta
const saveQuestions = async function () {
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    const questionDivs = Array.from(document.querySelectorAll(".question-div"));

    questionDivs.forEach((div, index) => {
        const questionInput = div.querySelector(".question");
        const answersDivs = Array.from(div.querySelectorAll(".answer_div .answer"));
        const imageInput = div.querySelector(".has-picture-main .picture-div-holder .file-input");

        formData.append(`questions[${index}][examId]`, examId);
        formData.append(`questions[${index}][questionValue]`, questionInput.value);

        let correctAnswerValue = null;
        answersDivs.forEach((ansDiv, i) => {
            formData.append(`questions[${index}][answers][${i+1}]`, ansDiv.value);
            if (ansDiv.classList.contains("correct")) {
                correctAnswerValue = ansDiv.value;
            }
        });

        if (correctAnswerValue) {
            formData.append(`questions[${index}][answers][is_correct]`, correctAnswerValue);
        }

        if (imageInput?.files?.length > 0) {
            formData.append(`questions[${index}][image]`, imageInput.files[0]);
        }
    });


    try {
        const response = await axios.post(
            `/nastavnik/provjera-znanja/${examId}/spremi-pitanja`,
            formData,
            {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                withCredentials: true
            }
        );

        if (response.status === 200) {
            setFlashMessage(response.data.message, SUCCESS_COLOR);
            setTimeout(() => {
                window.location.assign(`/nastavnik/provjera-znanja/${examId}`);
            }, 1500);
        }
    } catch (error) {

        if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            const messages = Object.values(errors).flat().join("<br>");
            setFlashMessage(messages, DANGER_COLOR);
        } else if (error.response?.status === 403) {
            setFlashMessage(error.response.data.message, DANGER_COLOR);
        } else {
            setFlashMessage(error.message, DANGER_COLOR);
        }
    }
};

const returnTopBtn = document.querySelector(".return-top");

window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
        returnTopBtn?.classList.add("show");
    } else {
        returnTopBtn?.classList.remove("show");
    }
});

returnTopBtn?.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
});



export const handleScrollBehavior = function(el) {
    window.scrollTo(el.getBoundingClientRect().x, el.getBoundingClientRect().y,{
    behavior: 'smooth',
    });
}

export const signalError = function(el, color) {
    el.style.backgroundColor = 'rgb(255, 86, 86)';
    setTimeout(() => {
        el.style.backgroundColor = color;
    }, 1000);
}

export const signalEmptyAnswers = function(questionDiv) {
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


export const signalEmptyAnswersInputs = function(answersAreas)
{
    let isEmpty;
    for(let i = 0 ; i < answersAreas.length ; i++)
    {
        if (!answersAreas[i].value) {
            isEmpty = true;
            answersAreas[i].style.backgroundColor = 'rgb(255, 86, 86)';
        }
    }
    setTimeout(() => {
        for(let i = 0 ; i < answersAreas.length ; i++)
        {
            if (answersAreas[i].style.backgroundColor = 'rgb(255, 86, 86)'){

                if (answersAreas[i].classList.contains('correct'))
                {
                    answersAreas[i].style.backgroundColor = '#aff3ce';
                } else {
                    answersAreas[i].style.backgroundColor = '#fff';
                }
            }
        }
    }, 1000);

    return isEmpty;
}


export const setFlashMessage = function(text, background)
{
    Toastify({
    text: text,
    duration: 5000,
    newWindow: true,
    close: true,
    gravity: "top",
    position: "center",
    stopOnFocus: true,
    style: {
        background: background,
        color: "#faf7f7",
        fontSize: "2rem"
    },
    onClick: function(){}
    }).showToast();
}

export const areAnswersUnique = function(answers) {
    const values = Object.entries(answers)
        .filter(([key]) => key !== 'is_correct')
        .map(([, inputEl]) => String(inputEl.value).trim());
    return new Set(values).size === values.length;
}


const createPictureSection = function(questionNumberId, appendEl) {

    const pictureDivHolder = document.createElement("div");
    pictureDivHolder.classList.add("picture-div-holder");

    const pictureDiv = document.createElement("div");
    pictureDiv.classList.add("question-picture");
    pictureDiv.id = questionNumberId;

    pictureDivHolder.appendChild(pictureDiv);

    const pictureInput = document.createElement("input");
    pictureInput.type = "file";
    pictureInput.name = "image";
    pictureInput.classList.add("file-input");

    pictureDivHolder.appendChild(pictureInput);

    appendEl.appendChild(pictureDivHolder);
}
