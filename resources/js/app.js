import './bootstrap';
import './auth';
import './admin_requests';
import './profile';
import './modal';
import './questions';
import './constants';
import './question_details';
import './code_generator';
import './exam_nav';
import './exam_state';
import './log_activity';
import './proctor';
import './spa_quiz';
import './quiz_control';
import './quiz_process';

document.addEventListener("DOMContentLoaded", () => {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const menu = document.getElementById("header-menu");

    if (hamburgerBtn && menu) {
        hamburgerBtn.addEventListener("click", () => {
            menu.classList.toggle("show");
        });
    }
});
