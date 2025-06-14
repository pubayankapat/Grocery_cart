let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
   navbar.classList.remove('active');
}
// Form validation
document.getElementById("form").addEventListener("click", (e) => {
    e.preventDefault();
});
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
function validateName(name) {
    const nameRegex = /^[a-zA-Z\s]+$/;
    return nameRegex.test(name);
}
let verifyPass = (pass) => {
    constpassRegEx = /[[a-zA-Z]+[0-9]+[\!\@\#\$\%\*\,\.\<\>]+]+/;
    if (pass.length > 8 && pass.length < 20) {
        returnpassRegEx.test(pass);
    } else {
        returnfalse;
    }
};
let button = document.getElementById("btnSubmit");
button.addEventListener("click", () => {
    let name = document.querySelector("#name").value;
    let email = document.querySelector("#email").value;
    let phone = document.querySelector("#phone").value;
    let pass = document.getElementById("pass").value;
    if (name.length < 4 || !validateName()) {
        alert("InvalidName");
    }
    if (!validateEmail(email)) {
        alert("Invalidemail");
    }
    if (phone.length < 10) {
        alert("InvalidPhoneNumber");
    }
    if (!verifyPass(pass)) {
        alert("InvalidPassword");
    }
});


