$("#btnSelectIdDict").click(dictamination);
function dictamination() {
  if ($("#comboBoxcostumer").val() == '' ) {
    console.log("Debe elegir una opcion");
    window.alert("Debe elegir una opcion");
    return false;
  } else {

    console.log("Estan bien");
     
     var url = "../../../../com/creditosBancarios/api/views/employeDictamination.php";
     $(location).attr('href',url);
  }
}

$("#btnSubmitRequest").click(sumitDictamination);
function sumitDictamination() {
     window.alert("Solicitud enviada");


}
