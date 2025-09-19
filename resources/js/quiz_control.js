import axios from "axios";
import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR} from './constants';
import { setFlashMessage } from "./questions";

document.addEventListener("DOMContentLoaded", () => {
    const questions = document.querySelectorAll('.question-wrap');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const startQuizBtn = document.getElementById("start_quiz");
    const navigationButtons = document.querySelector(".navigation-buttons");
    const proctorWrap = document.querySelector(".proctor-wrap");
    const examId = document.getElementById("exam_id")?.textContent;
    const connectedStudents = document.getElementById("connected_students");
    let studentCount = 0;
    let currentQuestion = parseInt(localStorage.getItem("current_question")) || 1;
    const totalQuestions = questions.length;
    const isQuizInProgress = parseInt(document.getElementById("quiz_started")?.textContent);
    const stopQuizBtn = document.querySelector(".stop-quiz");
    const userRole = document.getElementById("user_role")?.textContent;

    const quizChannel = window.Echo.join(`quiz.${examId}`)
    .here(users => {
        studentCount = Math.max(0, users.length - 1);
        if (connectedStudents) connectedStudents.textContent = studentCount;
    })
    .joining(user => {
        studentCount++;

        if (userRole === 'admin' || userRole === 'teacher') {
            quizChannel.whisper("c_q", {c_q: currentQuestion});
        }
        if (connectedStudents) connectedStudents.textContent = studentCount;
    })
    .leaving(user => {
        studentCount = Math.max(0, studentCount - 1);
        if (connectedStudents) connectedStudents.textContent = studentCount;
    });


    if (isQuizInProgress) {

        const pullFromLocalStorage = parseInt(localStorage.getItem("current_question")) || 1;
        showQuestion(pullFromLocalStorage);

        const questionToSend = document.querySelector(`.question-wrap[data-question="${pullFromLocalStorage}"]`);
        startQuizBtn.style.display = 'none';
        navigationButtons.style.display = 'flex';
        proctorWrap.style.display = 'flex';

        quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });
    }

    else {
        startQuizBtn?.addEventListener("click", function(e) {

            triggerQuizStart();

            const questionToSend = document.querySelector(`.question-wrap[data-question="1"]`);
            e.target.style.display = 'none';
            navigationButtons.style.display = 'flex';
            proctorWrap.style.display = 'flex';

            quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });
        });
    }

    function showQuestion (n){
        if (n < 1) n = totalQuestions;
        if (n > totalQuestions) n = 1;

        questions.forEach(q => q.style.display = 'none');

        const questionToSend = document.querySelector(`.question-wrap[data-question="${n}"]`);
        questionToSend.style.display = '';

        localStorage.setItem("current_question", questionToSend.getAttribute("data-question"));
        currentQuestion = n;

        return questionToSend;
    };

    prevBtn?.addEventListener('click', () => {
        const questionToSend = showQuestion(currentQuestion - 1);
        quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });

    });
    nextBtn?.addEventListener('click', function() {
        if (currentQuestion === totalQuestions) {
            return;

        } else {

            const questionToSend = showQuestion(currentQuestion + 1);
            quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });
        }
    });

    stopQuizBtn?.addEventListener("click", e => {
        localStorage.removeItem("current_question");
    });


    const triggerQuizStart = async function() {

        try {
            const request = await axios.patch(`/nastavnik/provjera-znanja/${examId}/pokreni-kviz`, {message: "started"}, {
                withCredentials: true
            });
            if (request.status === 200) {
                setFlashMessage(request.data.message, SUCCESS_COLOR);
            }

        } catch (error) {
            setFlashMessage("Nešto nije u redu.", DANGER_COLOR);
        }
    }

});
