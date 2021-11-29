<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-with, initial-scale=1.0">
  <link rel="stylesheet" href="../../../../com/creditosBancarios/api/views/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../../com/creditosBancarios/api/views/assets/css/style.css">

  <title></title>
</head>
  <body>
    <div  class="content container">

      <header class="content__header row">
        <div class="content__header__div-img-logo col-lg-3 col-md-3 sm-4 col-xs-4 row" >
        </div>

        <div id=""class="content__header__user col-lg-9 col-md-9 sm-8 col-xs-8 row">
          <aside class="content__header__user__col">
            <label for="" class="content__header__user__col__lbl-user">Nombre de cliente</label>
            <button id="btnLogOff"class="content__header__user__col__btn btn btn-primary" type="button" name="button">Cerrar sesión</button>
          </aside>
        </div>
      </header>

      <div  class="content__center-user">

        <ul class="content__center-user__list nav nav-tabs nav-fill" style="background: white">
          <li class="content__center-user__list__item nav-item">
            <a class="content__center-user__list__item__hyperlink nav-link " href="../../../../com/creditosBancarios/api/views/costumerCreditRequestCredit.php">Solicitud de credito</a>
          </li>
          <li class="content__center-user__list__item nav-item">
            <a class="content__center-user__list__item__hyperlink nav-link" href="../../../../com/creditosBancarios/api/views/costumerRenoReconCancel.php">Estado de credito</a>
          </li>
          <li class="content__center-user__list__item nav-item">
            <a class="content__center-user__list__item__hyperlink nav-link " data-toggle="collapse" href="#divNotification" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Notificaciones</a>
          </li>

        </ul>
        <div class="col content__center-user__notification">
              <div class="collapse multi-collapse" id="divNotification">
                <div class="card card-body">
                  <ul class="list-group">
                    <li class="list-group-item">Notificación 1</li>
                    <li class="list-group-item">Notificación 2</li>
                    <li class="list-group-item">Notificación 3</li>
                    <li class="list-group-item">Notificación 4</li>
                    <li class="list-group-item">Notificación 5</li>
                  </ul>
            </div>
          </div>
        </div>

        <div id=""class="content__center-user__div-data col-lg-10 col-md-12 sm-12 col-xs-12"  >
          <!--ComboBox de tipo de credito-->
          <select  multiple class="content__center-user__div-data__cmb-box form-control" id="statusCostumer">
            <option id="DEBIT_CARD" value="Tarjeta de debito">Tarjeta de debito</option>
            <option id="CREDIT_CARD" value="Tarjeta de credito">Tarjeta de credito</option>
            <option id="MORTAGE" value="Hipotecario">Hipotecario </option>
            <option id="CAR" value="Automovil">Automovil</option>
          </select>

            <textarea id="statusCredit"  disabled class="content__center-user__div-data__txta--credit form-control" rows="5" id="comment"></textarea>
            <div class="row" >
              <button type="button"  id="btnReconsideration" class="content__center-user__div-data__btn btn btn-primary">Reconsideracion</button>
              <button type="button" id="btnRenovation"  class="content__center-user__div-data__btn btn btn-primary">Renovacion</button>
              <button type="button" id="btnCancellation"  class="content__center-user__div-data__btn btn btn-primary">Cancelacion</button>
            </div>
            <textarea id="txtaReconsideration"   class="content__center-user__div-data__txta--credit form-control d-none" rows="5" id="comment"></textarea>
            <button type="button" id="btnSumitReconsideration"  class="content__center-user__div-data__btn btn btn-primary d-none">Enviar solicitud</button>

        </div>

    </div>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/jquery-3.3.1.min.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/bootstrap.min.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/validationCostumeRenoReconCancel.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/sumitCostumerRenoReconCancel.js"></script>
  </body>
</html>
