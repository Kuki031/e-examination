const profilePictureDiv = document.querySelector(".profile-picture");
document.querySelector('#profile_picture')?.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        document.querySelector('.profile-picture').style.backgroundImage = `url('${e.target.result}')`;
    };
    reader.readAsDataURL(file);
});
