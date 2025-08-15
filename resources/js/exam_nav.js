import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR} from './constants';
import { setFlashMessage } from './questions';


if (document.getElementById("load_script")) {

    const attemptId = document.getElementById("attempt_id")?.textContent;
    const examId = parseInt(document.getElementById("exam_id")?.textContent);
    let isSent = false;

    document.addEventListener('DOMContentLoaded', () => {
    const timerElement = document.querySelector('.timer');
    const durationMinutes = parseInt(timerElement?.getAttribute('data-time'), 10);
    const startedAtUnix = parseInt(timerElement?.getAttribute('data-started-at'), 10);
    const nowUnix = Math.floor(Date.now() / 1000);
    const elapsedSeconds = nowUnix - startedAtUnix;
    const countdownSpan = document.getElementById('countdown');
    let timeLeft = durationMinutes * 60 - elapsedSeconds;

    if (timeLeft <= 0) {
        isSent = true;
        countdownSpan.textContent = "00:00";
        submitExam("Vrijeme je isteklo! Ispit će biti predan.");
        return;
    }


    const formatTime = function(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    const updateTimer = function() {

        if (countdownSpan) {

            if (timeLeft <= 0) {
                isSent = true;
                countdownSpan.textContent = "00:00";
                clearInterval(timerInterval);
                submitExam("Vrijeme je isteklo! Ispit će biti predan.");
                return;
            }

            countdownSpan.textContent = formatTime(timeLeft);
            timeLeft--;
        }
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);
    });

    document.addEventListener('DOMContentLoaded', () => {
    const questions = document.querySelectorAll('.question-wrap');
    const navButtons = document.querySelectorAll('.exam-process-nav-btn');
    const prevBtn = document.querySelector('.navigation-buttons button:nth-child(1)');
    const nextBtn = document.querySelector('.navigation-buttons button:nth-child(2)');


    let currentQuestion = parseInt(document.getElementById("current_question")?.textContent) || 1;
    const totalQuestions = questions.length;

    const showQuestion = function(n) {
        if (n < 1) n = totalQuestions;
        if (n > totalQuestions) n = 1;

        questions.forEach(q => q.style.display = 'none');

        const questionToShow = document.querySelector(`.question-wrap[data-question="${n}"]`);
        if (questionToShow) questionToShow.style.display = '';

        currentQuestion = n;

        navButtons.forEach(btn => btn.classList.remove('active-question'));
        const activeBtn = Array.from(navButtons).find(btn => btn.textContent == n);
        if (activeBtn) activeBtn.classList.add('active-question');

        if (currentQuestion === totalQuestions) {
            nextBtn.textContent = "Završi ispit";
        } else {
            nextBtn.textContent = "Sljedeće pitanje";
        }
    }
    navButtons.forEach(btn => {
        btn?.addEventListener('click', () => {
        const qNum = parseInt(btn.textContent);
        showQuestion(qNum);
        });
    });

    prevBtn?.addEventListener('click', () => {
        if (isSent) return;
        showQuestion(currentQuestion - 1);
    });

    nextBtn?.addEventListener('click', () => {

        if (isSent) return;

        else if (currentQuestion === totalQuestions) {

            const unAnsweredQuestions = determineUnansweredQuestions();

            const modal = document.querySelector(".modal-overlay");

            if (unAnsweredQuestions) {
                modal.querySelector(".modal-box .alert")?.classList.remove("hidden");
            } else {
                modal.querySelector(".modal-box .alert")?.classList.add("hidden");
            }

            modal.classList.add("active");
            modal.addEventListener("click", function(e) {
                let mainEl = e.target;
                if (!mainEl.classList.contains("modal-button")) return;

                if (mainEl.classList.contains('confirm')) {

                    nextBtn.setAttribute("disabled", "disabled");
                    prevBtn.setAttribute("disabled", "disabled");
                    submitExam("Pohrana ispita izvršena!");
                    e.stopImmediatePropagation();
                } else if (mainEl.classList.contains('cancel')) {
                    e.stopImmediatePropagation();
                    return;
                }
            })
        } else {
            showQuestion(currentQuestion + 1);
        }
    });

    showQuestion(currentQuestion);
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
                location.assign("/");
            }, 2000);
        }

        } catch (error) {
            console.error(error);

        }
    }

    const determineUnansweredQuestions = function() {
        const questions = prepareQuestionsForAjax();
        return questions.some(x => x === 0);
    }


    window.Echo.join(`exam.${examId}`)
        .listen('.exam.stopped', (e) => {
        isSent = true;
        submitExam("Ispit je prekinut! Vaš rezultat biti će pohranjen.");
    });

    window.Echo.join(`proctor.${examId}`);
}
