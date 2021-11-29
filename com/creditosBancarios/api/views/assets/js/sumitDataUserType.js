//Envio de email y password del cliente
function logUser() {
	email = $("#email").val();
	password = $("#password").val();
	dataUser = { action: "signIn", email: email, password: password };
	
	if (validatePassword() && validateEmail()) {
		$.post("../controllers/UserController.php", dataUser, function (response) {
			console.log(response);
			response = $.parseJSON(response);
			if (response.result == 1) {
				window.location.href = response.view;
			} else {
				$("#messageError").addClass("d-none");
				alert(response.message);
			}
		});
	}
}
