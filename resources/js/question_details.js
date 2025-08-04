import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR} from './constants';
import { signalEmptyAnswersInputs, setFlashMessage, areAnswersUnique, signalError, handleScrollBehavior } from './questions';

"use strict"

const mainAnswerDivWrap = document.querySelector(".answers-holder");
const answersLength = parseInt(document.querySelector('.answers-length').value);
let numberOfAnswers = parseInt(document.querySelector('.number-of-answers').textContent);

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

});


// Ako su samo dva odgovora, zabrani brisanje ++++
// Provjera je li označen točan odgovor (korisnik može obrisati točan odgovor pa kliknut update) ++++
// Priprema za ajax => redni broj odgovora mora biti prisutan



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
