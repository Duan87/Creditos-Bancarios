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
    <div  class="content-2 container">

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




      <div class="content__center-user col-lg-10 col-md-12 sm-12 col-xs-12 ">
        <!--ComboBox de empleado-->
        <select class="form-control">
          <option id="telephoneResearch" value="">Investigación Telefonica</option>
          <option id="notificationCostumer" value="">Notificación para usuario</option>
          <option id="observationRequest" value="">Observación de solicitudes pendientes</option>
        </select>



        <p>Solicitudes</p>
        <!--ComboBox de solicitudes-->
        <select class="form-control">
          <option id="Id1" value="">Pendientes</option>
          <option id="Id2" value="">Reconsideraciones</option>
        </select>



        <div class="col-lg-5 col-md-6 sm-3 col-xs-4 border border-light" >
          <p id="keyRequest">Clave unica de solicitud</p>
        </div>

        <p>Datos del solicitante</p>

        <table id="costumer" class="">
            <tr  class="">
              <th  >Nombre</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th>Domicilio</th>
              <td>Jacob</td>
            </tr>
            <tr>
              <th scope="row">RFC</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">CURP</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Numero telefonico</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Correo</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Empresa en la que trabaja</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Puesto</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Sueldo Mensual</th>
              <td>Larry</td>
            </tr>
        </table>

        <p>Referencias</p>

        <table id="references" class="">
            <tr>
              <th scope="row">Nombre</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Numero telefonico</th>
              <td>Jacob</td>
            </tr>
            <tr>
              <th scope="row">Años de conocer al solicitante</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Empresa en la que trabaja</th>
              <td>Larry</td>
            </tr>
            <tr>
              <th scope="row">Numero telefonico</th>
              <td>Larry</td>
            </tr>

        </table>
        <p>Observaciones</p>
        <textarea  id="observations"class="form-control" rows="5" id="comment"></textarea>

        <p>Estatus de buro de credito</p>
        <textarea style="height:30px;" id="bureauStatus" disabled class="form-control" rows="5" id="comment"></textarea>
          <button id="btnSumitInvestigation"class="btn btn-primary" type="button" name="button">Enviar</button>
      </div>


    </div>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/jquery-3.3.1.min.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/bootstrap.min.js"></script>
  </body>
</html>
