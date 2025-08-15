if (document.getElementById("activity_log")) {

    const examAttempt = document.getElementById("attempt_id")?.textContent;
    const examId = document.getElementById("exam_id")?.textContent;


    document.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.key.toLowerCase() === 'v') {
            sendLogUpdate({activity: `Zaljepljen sadržaj.`});
        }

    });

    document.addEventListener('visibilitychange', () => {

        if (document.hidden) {
            sendLogUpdate({activity: `Napuštanje prozora ispita.`});
        }
    });

    document.addEventListener('copy', function (event) {
        let copiedText = window.getSelection().toString();
        sendLogUpdate({ activity: `Pokušaj kopiranja sadržaja: ${copiedText || ''}`});

    });


    const sendLogUpdate = async function(data) {

        try {
            await axios.patch(`/ispiti/pokusaj/${examAttempt}/ispit/${examId}/aktivnost`, data , {
                withCredentials: true
            });

        } catch (error) {
            consoler.error(error);
        }
    }
}
