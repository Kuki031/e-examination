import axios from 'axios';

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
        console.error("Error fetching request count:", error);
    }
};

if (requestCountSpan) {
    getRequestCount();
}
