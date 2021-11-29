//Envio de solicitud telefonica
$("#btnbtnSumitInvestigation").click(function(event) {
	event.preventDefault();



  var investigation = //{"":};

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: investigation,
		dataType: "json"
	}).done(function(answerInvestigation){

		}
	);
});



//Envio de notificaciones
$("#btnSubmitNotification").click(function(event) {
	event.preventDefault();



  var notification =// {"":};

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: notification,
		dataType: "json"
	}).done(function(answerNotification){

		}
	);
});
