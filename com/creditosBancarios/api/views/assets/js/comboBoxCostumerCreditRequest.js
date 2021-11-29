$("#DEBIT_CARD").click(function () {
  $("#DEBIT").removeClass("d-none");
  $("#MORTAGE").addClass("d-none");
  $("#CAR").addClass("d-none");
  $("#CREDIT").addClass("d-none");

});

$("#CREDIT_CARD").click(function () {
  $("#CREDIT").removeClass("d-none");
  $("#DEBIT").addClass("d-none");
  $("#CAR").addClass("d-none");
  $("#MORTAGE").addClass("d-none");
});

$("#CREDIT_CAR").click(function () {
  $("#CAR").removeClass("d-none");
  $("#DEBIT").addClass("d-none");
  $("#MORTAGE").addClass("d-none");
  $("#CREDIT").addClass("d-none");
});

$("#CREDIT_MORTAGE").click(function () {
  $("#MORTAGE").removeClass("d-none");
  $("#DEBIT").addClass("d-none");
  $("#CAR").addClass("d-none");
  $("#CREDIT").addClass("d-none");
});
