if (document.getElementById("start_proctoring")) {
    const examId = document.getElementById("exam_id")?.textContent;
    const mainWrap = document.querySelector(".proctor-wrap");
    const notifyBtn = document.querySelector(".notify");

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
            const picture = students[i].picture
                ? "/storage/" + students[i].picture
                : "/images/auth_module/user_placeholder.png";

            el.style.backgroundImage = `url(${picture})`;

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
        const pic = picture
            ? "/storage/" + picture
            : "/images/auth_module/user_placeholder.png";

        el.style.backgroundImage = `url(${pic})`;
        wrapEl.appendChild(el);
        wrapEl.appendChild(spanEl);

        return wrapEl;
    }

    notifyBtn?.addEventListener("click", function(e) {
        const input = document.getElementById("notification")?.value;
        if (!input) {
            return;
        }

        sendNotification(input);

    });

    const sendNotification = async function(msg) {

        try {
            await axios.post(`/ispiti/ispit/${examId}/posalji-notifikaciju`, {notification: msg}, {
                withCredentials: true
            });

        } catch (error) {
            console.error(error);
        }
    }
}
