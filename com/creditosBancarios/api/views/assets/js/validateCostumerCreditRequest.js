$("#btnSelectTermCredit").click(comboTypeCredit);

function comboTypeCredit() {
  if ($("#DEBIT").val() == '' && $("#CREDIT").val() == '' && $("#CAR").val() == '' && $("#MORTAGE").val() == '') {
    console.log("Debe elegir una opcion");
    window.alert("Debe elegir una opcion");
    return false;
  } else {
    console.log("Estan bien");

     
     var url = "../../../../com/creditosBancarios/api/views/costumerViews.php";
     $(location).attr('href',url);
  }

}
