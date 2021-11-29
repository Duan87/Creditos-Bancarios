//Envio de la solicitud de reconsideracion del credito
$("#btnSumitReconsideration").click(function (event) {
	event.preventDefault();

	var CreditTypes = $("#creditType").val();
	var reconsideration = $("#txtaReconsideration").val();
	var requestReconsideration = {
		"CreditTypes": CreditTypes,
		"reconsiderationMotive": reconsideration
	}

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: requestReconsideration,
		dataType: "json"
	}).done(function (answerReconsideration) {

	});
});

//Envio de la solicitud de renovacion del credito
$("#btnRenovation").click(function (event) {
	event.preventDefault();

	var CreditTypes = $("#creditType").val();
	var requestRenovation = {
		"CreditTypes": CreditTypes
	}

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: requestRenovation,
		dataType: "json"
	}).done(function (answerRenovation) {

	});
});

//Envio de la solicitud de Cancelacion del credito
$("#btnCancellation").click(function (event) {
	event.preventDefault();

	var CreditTypes = $("#creditType").val();
	var requestCancellation = {
		"CreditTypes": CreditTypes
	}

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: requestCancellation,
		dataType: "json"
	}).done(function (answerCancellation) {

	});
});