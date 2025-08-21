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
    let currentQuestion = 1;
    const totalQuestions = questions.length;


    const quizChannel = window.Echo.join(`quiz.${examId}`)
    .here(users => {
        studentCount = Math.max(0, users.length - 1);
        if (connectedStudents) connectedStudents.textContent = studentCount;
    })
    .joining(user => {
        studentCount++;
        if (connectedStudents) connectedStudents.textContent = studentCount;
    })
    .leaving(user => {
        studentCount = Math.max(0, studentCount - 1);
        if (connectedStudents) connectedStudents.textContent = studentCount;
    });

    startQuizBtn?.addEventListener("click", function(e) {

        const questionToSend = document.querySelector(`.question-wrap[data-question="1"]`);
        e.target.style.display = 'none';
        navigationButtons.style.display = 'flex';
        proctorWrap.style.display = 'flex';

        quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });
    });


    const showQuestion = (n) => {
        if (n < 1) n = totalQuestions;
        if (n > totalQuestions) n = 1;

        questions.forEach(q => q.style.display = 'none');
        const questionToSend = document.querySelector(`.question-wrap[data-question="${n}"]`);
        questionToSend.style.display = '';

        currentQuestion = n;
        nextBtn.textContent = (n === totalQuestions) ? "Završi ispit" : "Sljedeće pitanje";

        return questionToSend;
    };

    prevBtn?.addEventListener('click', () => {
        const questionToSend = showQuestion(currentQuestion - 1);
        quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });

    });
    nextBtn?.addEventListener('click', () => {
        if (currentQuestion === totalQuestions) {
            // Emit finish state signal over socket
            alert("Ispit završen!");
        } else {

            const questionToSend = showQuestion(currentQuestion + 1);
            quizChannel.whisper("questionNumber", { q: questionToSend.getAttribute("data-question") });
        }
    });
});
