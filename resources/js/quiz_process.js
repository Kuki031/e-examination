import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR, WARNING_COLOR} from './constants';
import { setFlashMessage } from './questions';

document.addEventListener("DOMContentLoaded", () => {

    const startProcessScript = document.getElementById("load_process_script");
    if (startProcessScript) {

        const loadCheckedAnswer = function() {
            const answers = Array.from(document.querySelectorAll(".answers-wrap input"));
            return answers.filter(a => a.checked);
        }

        const updateState = async function() {
            try {

                const answers = loadCheckedAnswer();
                const freshCheckedAnswers = answers.map(el => el.id);

                const request = await axios.patch(`/ispiti/pokusaj/${attemptId}/ispit/${examId}/spremi-stanje`, {
                    checked_answers: freshCheckedAnswers,
                }, {
                    withCredentials: true
                });

            } catch (error) {
                console.error(error);
            }
        }


        const examId = document.getElementById("exam_id").textContent;
        const userId = document.getElementById("user_id").textContent;
        const attemptId = document.getElementById("attempt_id").textContent;
        const questionsWraps = Array.from(document.querySelectorAll(".question-wrap"));
        const questionSection = document.querySelector(".question-section");
        const isQuizInProgress = parseInt(document.getElementById("is_quiz_in_process")?.textContent);

        window.Echo.join(`quiz.${examId}`)
        .here(() => {})
        .joining(() => {})
        .leaving(() => {})
        .listen('.quiz.stopped', (e) => {
            submitExam("Kviz je završio! Vaš rezultat biti će pohranjen.");
        })
        .listenForWhisper('c_q', (e) => {

            if (isQuizInProgress) {
                questionSection.style.display = 'flex';
                questionsWraps.forEach(q => q.style.display = 'none');
                document.querySelector(`.question-wrap[data-question="${e.c_q}"]`).style.display = 'flex';
            }
        })
        .listenForWhisper('questionNumber', e => {

            if (!isQuizInProgress) {
                document.querySelector(".exam-header").style.display = 'none';
            }

            questionSection.style.display = 'flex';
            questionsWraps.forEach(q => q.style.display = 'none');
            document.querySelector(`.question-wrap[data-question="${e.q}"]`).style.display = 'flex';

        })



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

    let persistState = setInterval(() => {
        updateState();
    }, 5000);

    const submitExam = async function(message) {

        const answerList = prepareQuestionsForAjax();

        try {

            const request = await axios.patch(`/ispiti/pokusaj/${attemptId}/ispit/${examId}/spremi-ispit`, { answerList }, {
                withCredentials: true
            });

        if (request.status === 200) {
            clearInterval(persistState);

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
