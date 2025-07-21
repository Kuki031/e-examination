import axios from 'axios';

document.querySelector("#log-out")?.addEventListener("click", (e) => {
    logOut();
});

const logOut = async function()
{
    await axios.get('/');
    const request = await axios.post("/autentifikacija/odjavi-se", {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
        withCredentials: true,
    })
    if(request.status === 200)
    {
        window.location.assign("/");
    }
}
