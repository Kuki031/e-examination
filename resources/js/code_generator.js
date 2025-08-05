import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
import {DANGER_COLOR, SUCCESS_COLOR} from './constants';
import { setFlashMessage } from './questions';

const examId = document.querySelector('.exam_id')?.textContent;
document.querySelector('.exam-code-input-button')?.addEventListener("click", (e) => {
    e.preventDefault();
    const input = document.querySelector(".exam-code-input-input");
    input.value = randomString();

    saveCode({access_code: input.value});
});

const randomString = function() {
  return Math.random().toString(36).substring(2, 2 + 6);
}

const saveCode = async function(data) {
    try {

        const request = await axios.patch(`/nastavnik/provjera-znanja/${examId}/spremi-kod`, data,
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                withCredentials: true,
            });

            if(request.status === 200) {
                setFlashMessage(request.data.message, SUCCESS_COLOR);
            }

    } catch (error) {
        setFlashMessage(error, DANGER_COLOR);
    }
}
