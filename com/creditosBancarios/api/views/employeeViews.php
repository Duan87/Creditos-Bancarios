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
            <label for="" class="content__header__user__col__lbl-user">Nombre de empleado</label>
            <button id="btnLogOff"class="content__header__user__col__btn btn btn-primary" type="button" name="button">Cerrar sesión</button>
          </aside>
        </div>
      </header>

      <div  class="content__center-user__div-data col-lg-10 col-md-10 sm-8 col-xs-8 ">
        <select class="content__center-user__div-data__cmb-box--unfolds form-control">
          <option id="telephoneResearch" value="">Investigación Telefonica</option>
          <option id="notificationCostumer" value="">Notificación para usuario</option>
          <option id="observationRequest" value="">Observación de solicitudes pendientes</option>
        </select>
        <div class="">
          <button id="btnAcceptManager"class="content__center-user__div-data__btn btn btn-primary" type="button" name="button">Aceptar</button>
        </div>
      </div>



    </div>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/jquery-3.3.1.min.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/bootstrap.min.js"></script>
  </body>
</html>
