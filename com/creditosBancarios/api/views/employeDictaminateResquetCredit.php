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
    <div class="content container container">

      <header class="content__header row">
        <div  class="content__header__div-img-logo col-lg-3 col-md-3 sm-4 col-xs-4 row ">
        </div>

        <div class="content__header__user col-lg-9 col-md-9 sm-8 col-xs-8 ">
          <aside class="content__header__user__col">
            <label for="" class="content__header__user__col__lbl-user">Nombre de dictaminador </label>
            <button id="btnLogOff"class="content__header__user__col__btn btn btn-primary" type="button" name="button">Cerrar sesión</button>
          </aside>
        </div>
      </header>

      <!--ComboBox de dictaminador -->
      <div class="content__center-user__div-data col-lg-10 col-md-10 sm-10 col-xs-10 ">
          <p>Dictaminador</p>

          <!--Barra de busqueda de ID-->
        <div id="navSearchID" class="">
          <nav class="">
            <form class="form-inline">
              <input class="form-control mr-sm-2" type="search"   placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0"  type="submit">Search</button>
            </form>
          </nav>
        </div>


        <!--ComboBox de id de clientes-->
          <select multiple class="content__center-user__div-data__cmb-box form-control" id="comboBoxcostumer">
            <option id="Id1Dictaminator" value="Nombre de cliente ID1">Nombre de cliente ID1</option>
            <option id="Id2Dictaminator" value="Nombre de cliente ID2">Nombre de cliente ID2 </option>
            <option id="Id3Dictaminator" value="Nombre de cliente ID3">Nombre de cliente ID3 </option>
            <option id="Id4Dictaminator" value="Nombre de cliente ID4">Nombre de cliente ID4 </option>
          </select>

          <!--Boton para seleccionar un cliente-->
            <button id="btnSelectIdDict"  class="content__center-user__div-data__btn btn btn-primary" type="button" name="btnSelectIdDict">Seleccionar</button>

      </div>


    </div>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/jquery-3.3.1.min.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/import/bootstrap.min.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/validateEmployeeDictaminate.js"></script>
    <script src="../../../../com/creditosBancarios/api/views/assets/js/sumitEmployeeDictaminate.js"></script>
  </body>
</html>
