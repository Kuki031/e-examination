if (document.getElementById("start_proctoring")) {
    const examId = document.getElementById("exam_id")?.textContent;
    const mainWrap = document.querySelector(".proctor-wrap");

    window.Echo.join(`proctor.${examId}`)
        .joining((user) => {
            const appendDiv = appendStudent(user.id, user.picture, user.name);
            mainWrap.appendChild(appendDiv);
        })
        .leaving((user) => {
            const removeDiv = removeStudent(user.id);
            mainWrap.removeChild(removeDiv.parentElement);
        })
        .here((users) => {
            renderStudentsOnLoad(users, mainWrap);
        });


    const renderStudentsOnLoad = function(students, appendEl) {

        for(let i = 0 ; i < students.length ; i++) {

            const wrapEl = document.createElement("div");
            wrapEl.classList.add("card-wrapper");

            const el = document.createElement("div");
            const spanEl = document.createElement("span");
            spanEl.textContent = students[i].name;

            el.classList.add("student-card");
            el.id = `${students[i].id}`;
            el.style.backgroundImage = `url(/storage/${students[i].picture})`;

            if (students[i].role === 'admin' || students[i].role === 'teacher')
            {
                continue;
            }
            wrapEl.appendChild(el);
            wrapEl.appendChild(spanEl);
            appendEl.appendChild(wrapEl);
        }
    }

    const removeStudent = function(id) {

        const studentCards = Array.from(document.querySelectorAll(".student-card"));
        const leftStudent = studentCards.find(x => parseInt(x.id) === parseInt(id));

        return leftStudent;
    }

    const appendStudent = function(id, picture, name) {
        const wrapEl = document.createElement("div");
        wrapEl.classList.add("card-wrapper");

        const spanEl = document.createElement("span");
        spanEl.textContent = name;
        const el = document.createElement("div");
        el.classList.add("student-card");
        el.id = `${id}`;
        el.style.backgroundImage = `url(/storage/${picture})`;
        wrapEl.appendChild(el);
        wrapEl.appendChild(spanEl);

        return wrapEl;
    }
}
