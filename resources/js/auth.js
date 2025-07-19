import axios from 'axios';

document.querySelector("#log-out")?.addEventListener("click", (e) => {
    logOut();
});

const logOut = async function()
{
    await axios.get('/');
    const request = await axios({
        method: "POST",
        url: "http://127.0.0.1:8000/autentifikacija/odjavi-se"
    })

    if(request.status === 200)
    {
        window.location.assign("/");
    }
}
