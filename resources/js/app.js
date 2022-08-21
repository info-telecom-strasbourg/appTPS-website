require('./bootstrap');

// show a message with a type of the input
function showMessage(input, message, type) {
    // get the small element and set the message
    const msg = input.parentNode.querySelector("small");
    msg.innerText = message;
    // update the class for the input
    input.className = type ? "success" : "error";
    return type;
}

function showError(input, message) {
    return showMessage(input, message, false);
}

function showSuccess(input) {
    return showMessage(input, "", true);
}

function hasValue(input, message) {
    if (input.value.trim() === "") {
        return showError(input, message);
    }
    return showSuccess(input);
}

function validateEmail(input, requiredMsg, invalidMsg) {
    // check if the value is not empty
    if (!hasValue(input, requiredMsg)) {
        return false;
    }
    // validate email format
    const emailRegex =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    const email = input.value.trim();
    if (!emailRegex.test(email)) {
        return showError(input, invalidMsg);
    }
    return true;
}
function verifOrga(input) {
    if (input.value.trim() === "") {
        return showError(input, "")
    }
    else { return true; }
}

const form = document.querySelector("#signup");

const TITLE_REQUIRED = "Un titre ce serait bien";
const EMAIL_REQUIRED = "Un email ce serait bien";
const EMAIL_INVALID = "Un email correct ce serait bien";

form.addEventListener("submit", function (event) {
    // stop form submission
    event.preventDefault();

    // validate the form
    let nameValid = hasValue(form.elements["titre"], TITLE_REQUIRED);
    let emailValid = validateEmail(form.elements["email"], EMAIL_REQUIRED, EMAIL_INVALID);
    let orgaValid = verifOrga(form.elements["organisation"])
    // if valid, submit the form.
    if (nameValid && emailValid && orgaValid) {
        alert("ça fonctionne pas encore lol");
    }
});