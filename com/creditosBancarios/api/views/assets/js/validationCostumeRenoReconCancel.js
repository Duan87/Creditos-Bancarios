$("#btnReconsideration").click(reconsideration);
$("#btnRenovation").click(typeCredit);
$("#btnCancellation").click(typeCredit);

function typeCredit() {
  if ($("#statusCostumer").val() == '' ) {

    window.alert("Debe elegir una opcion");
    return false;
  } else {
    console.log("Estan bien");
     window.alert("Solicitud enviada");
     var url = "../../../../com/creditosBancarios/api/views/costumerViews.php";
     $(location).attr('href',url);
  }

}




function reconsideration() {
  if ($("#statusCostumer").val() == '' ) {
    
    window.alert("Debe elegir una opcion");
    return false;
  } else {
      $("#txtaReconsideration").removeClass("d-none");
      $("#btnSumitReconsideration").removeClass("d-none");

      $("#btnCancellation").attr("disabled", true);
      $("#btnReconsideration").attr("disabled", true);
      $("#btnRenovation").attr("disabled", true);

  }

}

$("#btnSumitReconsideration").click(sumitReconsideration);

function sumitReconsideration() {
  if ($("#txtaReconsideration").val() == '')
  {
     window.alert("Debe escribir la reconsideración");
     return false;
   }else {
     window.alert("Reconsideración envíada");
     var url = "../../../../com/creditosBancarios/api/views/costumerViews.php";
     $(location).attr('href',url);
   }
}
