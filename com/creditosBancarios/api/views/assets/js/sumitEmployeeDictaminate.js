//Envio del id del cliente
$("#btnSelectIdDict").click(function(event) {
	event.preventDefault();

	var idCostumer = $("#comboBoxcostumer").val();
  console.log(idCostumer);

  var costumer = {"idCostumer":idCostumer}

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: costumer,
		dataType: "json"
	}).done(function(answerCostumer){

		}
	);
});


$("#btnSubmitRequest").click(function(event) {
	event.preventDefault();



  var requestDictamination = {"":}

	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: requestDictamination,
		dataType: "json"
	}).done(function(answerDictamination){

		}
	);
});
