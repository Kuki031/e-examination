import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR, WARNING_COLOR} from './constants';
import { setFlashMessage } from './questions';

document.addEventListener("DOMContentLoaded", () => {

    const startProcessScript = document.getElementById("load_process_script");
    if (startProcessScript) {

        const examId = document.getElementById("exam_id").textContent;
        const userId = document.getElementById("user_id").textContent;
        const attemptId = document.getElementById("attempt_id").textContent;
        const questionsWraps = Array.from(document.querySelectorAll(".question-wrap"));
        const questionSection = document.querySelector(".question-section");


        window.Echo.join(`quiz.${examId}`)
        .here(() => {})
        .joining(() => {})
        .leaving(() => {})
        .listen('.quiz.stopped', (e) => {
            submitExam("Kviz je završio! Vaš rezultat biti će pohranjen.");
        })
        .listenForWhisper('questionNumber', e => {
            document.querySelector(".exam-header").style.display = 'none';

            questionSection.style.display = 'flex';
            questionsWraps.forEach(q => q.style.display = 'none');
            document.querySelector(`.question-wrap[data-question="${e.q}"]`).style.display = 'flex';

        });



        const prepareQuestionsForAjax = function() {
        const questionArray = Array.from(document.querySelectorAll(".question-text"))
            ?.map(q => q.textContent.trim());

        const checkedAnswers = Array.from(document.querySelectorAll('.answers-wrap'))
            ?.map(div => {
                return Array.from(div.querySelectorAll('.answer'))?.map(inp => inp.checked ? inp.parentElement.textContent.trim() : 0).filter(x => x || 0);
            })
            ?.map(x => {
                return x.length ? x[0] : 0;
            })


        return checkedAnswers;

    }


    const submitExam = async function(message) {

        const answerList = prepareQuestionsForAjax();

        try {

            const request = await axios.patch(`/ispiti/pokusaj/${attemptId}/ispit/${examId}/spremi-ispit`, { answerList }, {
                withCredentials: true
            });

        if (request.status === 200) {
            setFlashMessage(message, SUCCESS_COLOR)
            setTimeout(() => {
                location.assign(`/rezultati/${userId}`);
            }, 2000);
        }

        } catch (error) {
            setFlashMessage("Došlo je do pogreške.", DANGER_COLOR);
        }
    }
    }
});
