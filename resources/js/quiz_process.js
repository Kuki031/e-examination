document.addEventListener("DOMContentLoaded", () => {

    const startProcessScript = document.getElementById("load_process_script");
    if (startProcessScript) {

        const examId = document.getElementById("exam_id").textContent;
        const questionsWraps = Array.from(document.querySelectorAll(".question-wrap"));
        const questionSection = document.querySelector(".question-section");


        window.Echo.join(`quiz.${examId}`)
        .here(() => {})
        .joining(() => {})
        .leaving(() => {})
        .listenForWhisper('questionNumber', e => {
            questionSection.style.display = 'flex';
            questionsWraps.forEach(q => q.style.display = 'none');
            document.querySelector(`.question-wrap[data-question="${e.q}"]`).style.display = 'flex';

        });
    }
});
