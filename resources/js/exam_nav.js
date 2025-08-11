document.addEventListener('DOMContentLoaded', () => {
  const timerElement = document.querySelector('.timer');
  const durationMinutes = parseInt(timerElement.getAttribute('data-time'), 10);
  const startedAtUnix = parseInt(timerElement.getAttribute('data-started-at'), 10);

  const nowUnix = Math.floor(Date.now() / 1000);
  const elapsedSeconds = nowUnix - startedAtUnix;
  let timeLeft = durationMinutes * 60 - elapsedSeconds;

  if (timeLeft <= 0) {
    document.getElementById('countdown').textContent = "00:00";
    alert("Vrijeme je isteklo! Ispit će biti predan.");
    // TODO: submit the exam or redirect
    return;
  }

  const countdownSpan = document.getElementById('countdown');

   const formatTime = function(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  }

   const updateTimer = function() {
    if (timeLeft <= 0) {
      countdownSpan.textContent = "00:00";
      clearInterval(timerInterval);
      alert("Vrijeme je isteklo! Ispit će biti predan.");
      // TODO: submit the exam or redirect
      return;
    }
    countdownSpan.textContent = formatTime(timeLeft);
    timeLeft--;
  }

  updateTimer();
  const timerInterval = setInterval(updateTimer, 1000);
});

document.addEventListener('DOMContentLoaded', () => {
  const questions = document.querySelectorAll('.question-wrap');
  const navButtons = document.querySelectorAll('.exam-process-nav-btn');
  const prevBtn = document.querySelector('.navigation-buttons button:nth-child(1)');
  const nextBtn = document.querySelector('.navigation-buttons button:nth-child(2)');

  let currentQuestion = 1;
  const totalQuestions = questions.length;

  const showQuestion = function(n) {
    if (n < 1) n = totalQuestions;
    if (n > totalQuestions) n = 1;

    questions.forEach(q => q.style.display = 'none');

    const questionToShow = document.querySelector(`.question-wrap[data-question="${n}"]`);
    if (questionToShow) questionToShow.style.display = '';

    currentQuestion = n;

    navButtons.forEach(btn => btn.classList.remove('active'));
    const activeBtn = Array.from(navButtons).find(btn => btn.textContent == n);
    if (activeBtn) activeBtn.classList.add('active');
  }

  navButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const qNum = parseInt(btn.textContent);
      showQuestion(qNum);
    });
  });

  prevBtn.addEventListener('click', () => {
    showQuestion(currentQuestion - 1);
  });

  nextBtn.addEventListener('click', () => {
    showQuestion(currentQuestion + 1);
  });

  showQuestion(currentQuestion);
});
