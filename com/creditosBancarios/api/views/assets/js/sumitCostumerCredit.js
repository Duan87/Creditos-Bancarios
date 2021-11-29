//Envio de la solicitud del credito 
$("#btnSelectTermCredit").click(function(event) {
	event.preventDefault();

	var CreditTypes = $("#creditType").val();


  if (CreditTypes == "Tarjeta de credito") {
    var CardAmounts = $("#CREDIT").val();
  } else if (CreditTypes == "Tarjeta de debito") {
    var CardAmounts = $("#DEBIT").val();
  } else if (CreditTypes == "Hipotecario") {
    var CardAmounts = $("#MORTAGE").val();
  } else if (CreditTypes == "Automovil") {
    var CardAmounts = $("#CAR").val();
  }


  var creditType = {"CreditTypes":CreditTypes,
                      "CardAmounts":CardAmounts}
  console.log(creditType);
	$.ajax({
		url: "../../../../com/creditosBancarios/api/controllers/CreditController.php",
		type: "POST",
		data: creditType,
		dataType: "json"
	}).done(function(answer){

		}
	);
});
