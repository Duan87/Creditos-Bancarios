<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: userLogin.php');
    die();
} else {

    $userName = $_SESSION["userName"];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-with, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/import/popper.min.js"></script>
    <script src="assets/js/import/jquery-3.3.1.min.js"></script>
    <script src="assets/js/import/bootstrap.min.js"></script>
    <script src="assets/js/core.js"></script>
    <script src="assets/js/GUI.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/comboBoxCostumerCreditRequest.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/validateCostumerCreditRequest.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/sumitCostumerCredit.js"></script>
    <title></title>
</head>

<body onload="renderCustomerData(false);">
    <div class="content-2 container">

        <header class="content__header row">
            <div class="content__header__div-img-logo col-lg-3 col-md-3 sm-4 col-xs-4 row">
            </div>

            <!-- <h2>Referencias:</h2>
            <div class='row' id='refs-container'>
              <div class='container' id='firstRef'data-filled=0></div>
              <div class='container' id='secondRef'data-filled=0 ></div>
            </div>
            <div class="form-group">
              <label for="usr">Nombre:</label>
              <input id='ref-name'  class="form-control " required pattern="[a-zA-Z\s]{1,64}"  title="Sólo se permiten letras y una longitud de entre 1 y 64 caracteres">
            </div>
            <div class="form-group">
              <label for="usr">Apellido Paterno:</label>
              <input id='ref-pat' type="text" class="form-control " required pattern="[a-zA-Z\s]{1,64}"  title="Sólo se permiten letras y una longitud de entre 1 y 64 caracteres">
            </div>
            <div class="form-group ">
              <label for="usr">Apellido Materno:</label>
              <input id='ref-mat' type="text" class="form-control " required pattern="[a-zA-Z\s]{1,64}"  title="Sólo se permiten letras y una longitud de entre 1 y 64 caracteres">
            </div>
            <div class="form-group ">
              <label for="usr">Teléfono:</label>
              <input id='ref-phone' type="text" class="form-control " required pattern="[0-9]{8}" title="Debes introducir un número telefónico válido (8 caracteres)">
            </div>
            <div class="form-group ">
              <label for="usr">Años de conocerse:</label>
              <input id='ref-meeting' type="number" class="form-control " min="1" max="99" >
            </div> -->
        </header>

        <div class="content__center-user">

            <ul class="content__center-user__list nav nav-tabs nav-fill">
                <li class="content__center-user__list__item nav-item">
                    <a class="content__center-user__list__item__hyperlink nav-link " href="costumerViews.php">Mis creditos</a>
                </li>
                <li class="content__center-user__list__item nav-item">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Notificaciones
                    </button>
                    <div id='notif-budget' class="dropdown-menu">
                    </div>
                </li>

            </ul>
            <div id="" class="content__center-user__div-data col-lg-10 col-md-12 sm-12 col-xs-12">
                <div class="content__center-user__div-data__div-key col-lg-5 col-md-6 sm-3 col-xs-4 border border-light">
                    <p class="content__center-user__div-data-user__div-key__key" id="keyRequest">Clave unica de solicitud</p>
                </div>

                <!--ComboBox de tipo de credito-->

                <form onsubmit="return false">
                    <div class="form-group">
                        <label for="sel1">Créditos:</label>
                        <select class="form-control" id="credits-selector" onchange="displayForm(this);">
                            <option id="-1" value="NC">Selecciona un crédito</option>
                            <option id="1" value="Tarjeta de debito">Tarjeta de debito</option>
                            <option id="2" value="Tarjeta de credito">Tarjeta de credito</option>
                            <option id="3" value="Hipotecario">Hipotecario </option>
                            <option id="4" value="Automovil">Automovil</option>
                        </select>
                    </div>

                    <div id='debit-form' class='container d-none'>
                        <div class="form-group">
                            <label for="sel1">Tipos:</label>
                            <select class="form-control" id="credits-selector" onchange="displayDebitForm(this);">
                                <option id="-1" value="NC">Selecciona un crédito</option>
                                <option id="1" value="1">Tarjeta Débito I</option>
                                <option id="2" value="2">Tarjeta Débito II</option>
                                <option id="3" value="3">Tarjeta Débito III</option>
                            </select>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Monto fijo:</label>
                            <input id='debit-amount' type="text" class="form-control" readonly>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Plazo:</label>
                            <input id='debit-term' type="text" class="form-control" readonly>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Tasa de interés:</label>
                            <input id='debit-rate' type="text" class="form-control " readonly>
                        </div>
                    </div>

                    <div id='credit-form' class='container d-none'>
                        <div class="form-group">
                            <label for="sel1">Tipos:</label>
                            <select class="form-control" id="credits-selector" onchange="displayCreditForm(this);">
                                <option id="-1" value="NC">Selecciona un tipo</option>
                                <option id="1" value="4">Tarjeta Crédito I</option>
                                <option id="2" value="5">Tarjeta Crédito II</option>
                                <option id="3" value="6">Tarjeta Crédito III</option>
                            </select>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Monto fijo:</label>
                            <input id='credit-amount' type="text" class="form-control" readonly>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Plazo:</label>
                            <input id='credit-term' type="text" class="form-control " readonly>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Tasa de interés:</label>
                            <input id='credit-rate' type="text" class="form-control " readonly>
                        </div>
                    </div>

                    <div id='mortage-form' class='container d-none'>
                        <div class="form-group">
                            <label for="sel1">Tipos:</label>
                            <select class="form-control" id="credits-selector" onchange="displayMortageForm(this);">
                                <option id="-1" value="NC">Selecciona un tipo</option>
                                <option id="1" value="7">Hipoteca I</option>
                                <option id="2" value="8">Hipoteca II</option>
                                <option id="3" value="9">Hipoteca III</option>
                            </select>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Monto:</label>
                            <input id='mortage-amount' type="text" class="form-control" maxlength="5" onkeypress="return /\d/i.test(event.key)">
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Plazo:</label>
                            <input id='mortage-term' type="text" class="form-control " readonly>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Tasa de interés:</label>
                            <input id='mortage-rate' type="text" class="form-control " readonly>
                        </div>
                    </div>

                    <div id='car-form' class='container d-none'>
                        <div class="form-group">
                            <label for="sel1">Tipos:</label>
                            <select class="form-control" id="credits-selector" onchange="displayCarForm(this);">
                                <option id="-1" value="NC">Selecciona un tipo</option>
                                <option id="1" value="10">Carro I</option>
                                <option id="2" value="11">Carro II</option>
                                <option id="3" value="12">Carro III</option>
                                <option id="4" value="13">Carro IV</option>
                                <option id="5" value="14">Carro V</option>
                            </select>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Monto:</label>
                            <input id='car-amount' type="number" class="form-control " min="1000" max="9999999">
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Plazo:</label>
                            <input id='car-term' type="text" class="form-control " readonly>
                        </div>
                        <div class="form-group d-none">
                            <label for="usr">Tasa de interés:</label>
                            <input id='car-rate' type="text" class="form-control " readonly>
                        </div>
                    </div>

                    <h2>Referencias:</h2>
                    <div class='row' id='refs-container'>
                        <div class='container' id='firstRef' data-filled=0></div>
                        <div class='container' id='secondRef' data-filled=0></div>
                    </div>
                    <div id="references">
                        <div class="form-group">
                            <label for="ref-name">Nombre:</label>
                            <input id='ref-name' type='text' class="form-control" minlength='1' maxlength='64' onkeypress="return /[A-Za-z]/i.test(event.key)">
                        </div>
                        <div class="form-group">
                            <label for="ref-pat">Apellido Paterno:</label>
                            <input id='ref-pat' type="text" class="form-control" minlength='1' maxlength='64' onkeypress="return /[A-Za-z]/i.test(event.key)">
                        </div>
                        <div class="form-group ">
                            <label for="ref-mat">Apellido Materno:</label>
                            <input id='ref-mat' type="text" class="form-control" minlength='1' maxlength='64' onkeypress="return /[A-Za-z]/i.test(event.key)">
                        </div>
                        <div class="form-group">
                            <label for="ref-phone">Teléfono:</label><br>
                            <input id='ref-phone' type="number" class="form-control" minlength='1' maxlength='8'>
                        </div>
                        <div class="form-group">
                            <label for="ref-meeting">Años de conocerse:</label>
                            <input id='ref-meeting' type="number" class="form-control" minlength='1' maxlength="2" oninput="format(this);">
                        </div>
                        <div class="form-group">
                            <button id="btnAddRef" onClick="addRef();" class="content__center-user__div-data__btn btn btn-primary">Agregar Referencia</button>
                        </div>
                    </div>
                    <button onclick='requestCredit();' name="btnSelectTermCredit" id="btnSelectTermCredit" class="content__center-user__div-data__btn btn btn-primary" style="margin:20px;" type="button" name="btnSelectTermCredit">Aceptar</button>
            </div>
        </div>


    </div>
    <script type='text/javascript'>

    </script>
</body>

</html>
