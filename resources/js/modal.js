const actionBtn = document.querySelector('.strict-confirmation-btn');
const confirmModalBtn = document.querySelector(".confirm");
const cancelModalBtn = document.querySelector(".cancel");

const modalOverlay = document.querySelector('.modal-overlay')?.addEventListener("click", (e) => {
    e.target.classList.remove('active');
});

actionBtn?.addEventListener('click', () => {
    document.querySelector(".modal-overlay")?.classList.add('active');
});

confirmModalBtn?.addEventListener("click", (e) => {
    document.querySelector(".modal-overlay")?.classList.remove('active');
})

cancelModalBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    document.querySelector(".modal-overlay")?.classList.remove('active');
});

window.addEventListener("keyup", (e) => {
    if (e.key === 'Escape')
    {
        document.querySelector('.modal-overlay')?.classList.remove('active');
    }
})
