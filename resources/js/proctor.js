import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR, WARNING_COLOR} from './constants';
import { setFlashMessage } from './questions';

if (document.getElementById("start_proctoring")) {
    const examId = document.getElementById("exam_id")?.textContent;
    const mainWrap = document.querySelector(".proctor-wrap");
    const notifyBtn = document.querySelector(".notify");
    const searchStudent = document.getElementById("search_student");

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
            const anchorEl = document.createElement("a");
            anchorEl.textContent = students[i].name;
            anchorEl.href = `/nastavnik/korisnik/${students[i].id}/informacije`;
            anchorEl.classList.add("proctor-a");

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
            wrapEl.appendChild(anchorEl);
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

        const anchorEl = document.createElement("a");
        anchorEl.textContent = name;
        anchorEl.href = `/nastavnik/korisnik/${id}/informacije`;
        anchorEl.classList.add("proctor-a")
        const el = document.createElement("div");
        el.classList.add("student-card");
        el.id = `${id}`;
        const pic = picture
            ? "/storage/" + picture
            : "/images/auth_module/user_placeholder.png";

        el.style.backgroundImage = `url(${pic})`;
        wrapEl.appendChild(el);
        wrapEl.appendChild(anchorEl);

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
            const req = await axios.post(`/ispiti/ispit/${examId}/posalji-notifikaciju`, {notification: "Poruka od nastavnika: " + msg}, {
                withCredentials: true
            });

            if (req.status === 200) {
                const inp = document.getElementById("notification");
                inp.value = '';
                setFlashMessage("Notifikacija uspješno poslana.", SUCCESS_COLOR);
            }


        } catch (error) {
            console.error(error);
        }
    }

    const proctorSearch = function() {
        const searchInput = document.getElementById('search_student');
        const allStudents = Array.from(document.querySelectorAll('.card-wrapper .proctor-a'));

        if (!searchInput.value) {
            allStudents.forEach(student => student.parentElement.style.display = 'flex');
            return;
        }

        for (const student of allStudents) {
            const text = student.textContent.toLowerCase();
            const parentEl = student.parentElement;


            if (!text.includes(searchInput.value.toLowerCase())) {
                parentEl.style.display = 'none';
            } else {
                parentEl.style.display = 'flex';
            }
        }
    }

    searchStudent.addEventListener("keyup", proctorSearch);
}
