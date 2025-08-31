import axios from 'axios';
import { setFlashMessage } from './questions';
import { DANGER_COLOR } from './constants';

const requestCountSpan = document.querySelector("#request-number");

const getRequestCount = async function () {
    try {

        const request = await axios.get("/administrator/zahtjevi/brojka", {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
            withCredentials: true,
        });
        if (request.status === 200) {
            if (requestCountSpan) {
                requestCountSpan.textContent = request.data.count ?? request.data;
            }
        }
    } catch (error) {
        setFlashMessage("Došlo je do pogreške.", DANGER_COLOR);
    }
};

if (requestCountSpan) {
    getRequestCount();
}
