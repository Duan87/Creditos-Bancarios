$("#btnselectIdCostumer").click(investigation);
function investigation() {
  if ($("#costumerInvestigation").val() == '' ) {
    console.log("Debe elegir una opcion");
    window.alert("Debe elegir una opcion");
    return false;
  } else {

    console.log("Estan bien");
     window.alert("Solicitud enviada");
     var url = "../../../../com/creditosBancarios/api/views/employeeTelephonicInvestigation.php";
     $(location).attr('href',url);
  }
}


$("#btnSubmitNotification").click(notification);
function notification() {

}
