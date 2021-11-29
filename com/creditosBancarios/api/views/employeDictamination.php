<?php
require_once(__DIR__.'/../config/UserTypes.php');

session_start();
if(!isset($_SESSION["user"]) || $_SESSION["userType"] != UserTypes::DICTAMINATOR){
  header('Location: userLogin.php');
  die();
}else{
  $userName = $_SESSION["userName"];
  $requestObject = json_decode($_SESSION["requestObject"]);
  $request = $requestObject->request;
  $firstRef = $requestObject->references[0];
  $secondRef = $requestObject->references[1];
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-with, initial-scale=1.0">
  <link rel="stylesheet" href="../../../../com/creditosBancarios/api/views/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../../com/creditosBancarios/api/views/assets/css/style.css">
  <script src="assets/js/import/jquery-3.3.1.min.js"></script>
      <script src="../../../../com/creditosBancarios/api/views/assets/js/import/bootstrap.min.js"></script>
  <script src="assets/js/GUI.js"></script>
  <script src="assets/js/core.js"></script>
  <title></title>
</head>
  <body>
    <div  class="content container">

      <header class="content__header row">
        <div class="content__header__div-img-logo col-lg-3 col-md-3 sm-4 col-xs-4 row" >
        </div>

        <div id=""class="content__header__user col-lg-9 col-md-9 sm-8 col-xs-8 row">
          <aside class="content__header__user__col">
            <label for="" class="content__header__user__col__lbl-user"><?php echo $userName;?></label>
            <button onClick="logOutUser();" id="btnLogOff"class="content__header__user__col__btn btn btn-primary" type="button" name="button">Cerrar sesión</button>
          </aside>
        </div>
      </header>
      <div class='dividier'></div>
      <div class='jumbotron' data-request=<?php echo $request->id?>>
        <div class="container">
          <center><h1>Solicitud de crédito</h1></center>

          <!-- Datos de su solicitud -->
          <h2>Detalle de solicitud</h2>
          <div class='row'>
            <div class='col-md-12' >
              <dt>Tipo de crédito</dt>
              <dd><?php echo $request->credit_name; ?></dd>
              <dt>Plazo y Tasa de interés</dt>
              <dd><?php echo $request->term." años | ".$request->rate." anual"; ?></dd>
              <dt>Monto solicitado</dt>
              <dd><?php echo $request->amount; ?></dd>
              <dt>Monto fijo</dt>
              <dd><?php echo $request->fixed_amount; ?></dd>
            </div>
          </div>
          <!-- Datos del cliente -->
          <center><h2>Detalles del cliente</h2></center>
          <div class='row'>
            <div class='col-md-6'>
              <dl>
                <dt>Solicitante</dt>
                <dd><?php echo $request->customer; ?></dd>
                <dt>Email</dt>
                <dd><?php echo $request->mail; ?></dd>
                <dt>Dirección</dt>
                <dd><?php echo $request->street." #".$request->house_number; ?></dd>
                <dt>CURP</dt>
                <dd><?php echo $request->curp;?></dd>
              </dl>
            </div>
            <div class='col-md-6'>
              <dt>Empresa</dt>
              <dd><?php echo $request->company; ?></dd>
              <dt>Puesto</dt>
              <dd><?php echo $request->job; ?></dd>
              <dt>Salario</dt>
              <dd><?php echo $request->salary; ?></dd>
              <dt>RFC</dt>
              <dd><?php echo $request->rfc; ?></dd>
            </div>
          </div>
          <!-- Referencias -->
          <center><h2>Detalle de referencias</h2></center>
          <div class='row'>
            <div class='col-md-6' id='fstRef-Container' data-id=<?php echo $firstRef->id;?>>
              <h3>Referencia 1</h3>
              <dt>Nombre</dt>
              <dd><?php echo $firstRef->name." ".$firstRef->first_surname." ".$firstRef->second_surname; ?></dd>
              <dt>Teléfono</dt>
              <dd><?php echo $firstRef->telephone; ?></dd>
              <dt>Tiempo de conocerse</dt>
              <dd><?php echo $firstRef->timeMeeting; ?></dd>
              <dt>Observaciones del proceso de investigación</dt>
              <dd><?php echo $firstRef->remark; ?></dd>
            </div>
            <div class='col-md-6 ' id='sndRef-Container' data-id=<?php echo $secondRef->id; ?> >
              <h3>Referencia 2</h3>
              <dt>Nombre</dt>
              <dd><?php echo $secondRef->name." ".$secondRef->first_surname." ".$secondRef->second_surname; ?></dd>
              <dt>Teléfono</dt>
              <dd><?php echo $secondRef->telephone; ?></dd>
              <dt>Tiempo de conocerse</dt>
              <dd><?php echo $secondRef->timeMeeting; ?></dd>
              <dt>Observaciones del proceso de investigación</dt>
              <dd><?php echo $firstRef->remark; ?></dd>
            </div>
          </div>
          <h2>*Dictamen:</h2>
          <button onClick="dictaminateRequest(1,this);" class="btn btn-success" >Aprobar</button>
          <button onClick="dictaminateRequest(0,this);" class="btn btn-danger" >Declinar</button>
        </div>
      </div>
    </div>

  </body>
</html>
