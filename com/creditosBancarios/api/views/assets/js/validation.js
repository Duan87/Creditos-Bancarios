function validate() {
    if (validateEmail() == false || validatePassword() == false) {
        // $("#messageError").removeClass("d-none");
        return false;
    } else {
        $("#messageSucces").removeClass("d-none");
    }
}
$("#email").on("keyup", function () {
    validateEmail();
})

function validateEmail() {
    email = $("#email").val();
    var expressionEmail = /^\w+([.]\w+)?([@][a-z]+)*([.][a-z]{2,8}|[.][a-z]{2,10}[.][a-z]{2,8})$/;
    var emailUser = expressionEmail.test(email);

    if (emailUser == false) {
        $("#email").attr("class", "form-control is-invalid");
        $("#email")
            .parent()
            .children("span")
            .text("Debe ingresar un email")
            .attr("class", "invalid-feedback")
            .show();
        return false;
    } else if (emailUser == true) {
        $("#email").attr("class", "form-control is-valid");
        $("#email")
            .parent()
            .children("span")
            .text("Usuario válido")
            .attr("class", "valid-feedback")
            .show();
        return true;
    }
}

function validatePassword() {
    password = $("#password").val();
    var expressionPassword = /^(\w+){2,20}$/;
    var passwordUser = expressionPassword.test(password);

    if (passwordUser == false) {
        $("#password").attr("class", "form-control is-invalid");
        $("#password")
            .parent()
            .children("span")
            .text("Debe ingresar un password")
            .attr("class", "invalid-feedback")
            .show();
        console.log(password);
        return false;
    } else if (passwordUser == true) {
        $("#password").attr("class", "form-control is-valid");
        $("#password")
            .parent()
            .children("span")
            .text("Contraseña válida")
            .attr("class", "valid-feedback")
            .show();
        return true;
    }
}