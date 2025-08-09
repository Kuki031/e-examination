import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR} from './constants';
import { signalEmptyAnswersInputs, setFlashMessage, areAnswersUnique, signalError, handleScrollBehavior } from './questions';
import axios from 'axios';

"use strict"

const mainAnswerDivWrap = document.querySelector(".answers-holder");
const answersLength = parseInt(document.querySelector('.answers-length')?.value);
const questionId = parseInt(document.querySelector('.question-id')?.textContent);
const examId = parseInt(document.querySelector('.exam-id')?.value);
let numberOfAnswers = parseInt(document.querySelector('.number-of-answers')?.textContent);

document.querySelector(".new-answer")?.addEventListener("click", () => {
    addAnswer(mainAnswerDivWrap);
    numberOfAnswers++;
    document.querySelector(".number-of-answers").textContent = numberOfAnswers;
})


document.querySelector('.form-action-update-question')?.addEventListener("click", () => {
    document.querySelector(".question-details-content-form").submit();
});


mainAnswerDivWrap?.addEventListener("click", function(e) {
    let mainEl = e.target;
    if (mainEl.name === 'is_correct') {

        Array.from(document.querySelectorAll('.answer-actions .answer'))?.forEach((text, _index) => {
            if (text.classList.contains('correct')) {
                text.classList.remove('correct');
                text.style.backgroundColor = '#fff';
            }
        });
        const holderDiv =  mainEl.parentElement.parentElement.parentElement;
        const textArea = holderDiv.querySelector('textarea');
        textArea.style.backgroundColor = '#aff3ce';
        textArea.classList.add('correct');
        }

        else if (mainEl.classList.contains('answer-action-delete')) {

            if (Array.from(document.querySelectorAll('.answer-actions')).length <= 2) return;

            mainEl.parentElement.parentElement.remove();
            numberOfAnswers--;
            document.querySelector(".number-of-answers").textContent = numberOfAnswers;
        }
});


document.querySelector('.update-answers')?.addEventListener("click", (e) => {

    let hasError = false;
    const answers = Array.from(document.querySelectorAll('.answer'));

    for (const answer of answers) {
        if (!answer.value) {
            hasError = true;
            handleScrollBehavior(answer.parentElement);
            break;
        }
    }

    const hasEmptyAnswers = signalEmptyAnswersInputs(answers);
    if (hasEmptyAnswers) {
        setFlashMessage("Postoje prazni odgovori!", DANGER_COLOR);
    }

    const correctAnswer = document.querySelector(".correct");

    if (!correctAnswer) {
        hasError = true;
        setFlashMessage("Nije označen točan odgovor!", DANGER_COLOR);
    }

    const isAnswerArrayUnique = areAnswersUnique(answers);
    if (!isAnswerArrayUnique)
    {
        hasError = true;
        setFlashMessage("Postoje isti odgovori!", DANGER_COLOR);
    }

    if (hasError) {
        return;
    }

    const answersObj = {};
    const questions = {
        examId: examId,
        questionId: questionId
    };

    const answerInputs = Array.from(document.querySelectorAll('.answer-actions .answer'));
    for(let i = 0 ; i < answerInputs.length ; i++)
    {
        answersObj[i + 1] = answerInputs[i].value;
    }
    const correctAnswerInput = document.querySelector(".correct");
    answersObj.is_correct = correctAnswerInput.value;
    questions.answers = answersObj;


    saveAnswers({questions});

});




const addAnswer = function(mainEl) {

    const holderDiv = document.createElement("div");
    holderDiv.classList.add("answer-actions");
    mainEl.appendChild(holderDiv);
    const answerTextArea = document.createElement("textarea");
    answerTextArea.spellcheck = false;
    answerTextArea.cols = answersLength;
    answerTextArea.classList.add("question-details-input");
    answerTextArea.classList.add("answer");
    holderDiv.appendChild(answerTextArea);
    const answerActions = document.createElement("div");
    holderDiv.appendChild(answerActions);
    const deleteAnswerBtn = document.createElement("button");
    deleteAnswerBtn.classList.add("answer-action-delete");
    deleteAnswerBtn.textContent = "Obriši";
    answerActions.appendChild(deleteAnswerBtn);
    const isCorrectDiv = document.createElement("div");
    isCorrectDiv.classList.add("is-correct-div");
    answerActions.appendChild(isCorrectDiv);
    const isCorrectRadioInput = document.createElement("input");
    isCorrectRadioInput.type = "radio";
    isCorrectRadioInput.name = "is_correct";
    isCorrectDiv.appendChild(isCorrectRadioInput);
    const spanCorrect = document.createElement("span");
    spanCorrect.textContent = "Točan";
    isCorrectDiv.appendChild(spanCorrect);
}


const saveAnswers = async function (data) {
    try {
        const response = await axios.patch(`/nastavnik/provjera-znanja/${examId}/pitanja/${questionId}/azuriraj-odgovore`,
            data,
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                withCredentials: true,
            }
        );

        if (response.status === 200) {
            setFlashMessage(response.data.message, SUCCESS_COLOR);
            setTimeout(() => {
                window.location.assign(`/nastavnik/provjera-znanja/${examId}/pitanja/${questionId}`);
            }, 1500);
        }

    } catch (error) {
    if (error.response) {
        if (error.response.status === 422) {
            const errors = error.response.data.errors || {};
            const messages = Object.values(errors).flat().join('<br>');
            setFlashMessage(messages, DANGER_COLOR);
        } else if (error.response.status === 403) {
            setFlashMessage(error.response.data.message, DANGER_COLOR);
        } else {
            setFlashMessage(`Error: ${error.response.statusText}`, DANGER_COLOR);
        }
    } else {
        setFlashMessage(error.message, DANGER_COLOR);
    }
}
};
