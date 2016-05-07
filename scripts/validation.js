var i = 0;
window.onload = function () {


}
function checkName(caller) {
    var email = document.getElementById("email_field");
    if(caller.checkValidity()) {
        email.required = false;
    }
    else {
        email.required = true;
    }
}
function checkMail(caller) {
    var name = document.getElementById("name_field");
    if(caller.checkValidity()) {
        name.required = false;
    }
    else {
        name.required = true;
    }
}
