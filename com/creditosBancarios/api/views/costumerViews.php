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
<html lang="es" dir="ltr">

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
    <title>Solicitudes</title>
</head>

<body onload="renderCustomerData(true);">
    <div class="content container">

        <header class="content__header row">
            <div class="content__header__div-img-logo col-lg-3 col-md-3 sm-4 col-xs-4 row">
            </div>

            <div id="" class="content__header__user col-lg-9 col-md-9 sm-8 col-xs-8 row">
                <aside class="content__header__user__col">
                    <label for="" class="content__header__user__col__lbl-user"><?php echo $userName; ?></label>
                    <button id="btnLogOff" onclick="logOutUser();" class="content__header__user__col__btn btn btn-primary">Cerrar sesión</button>
                </aside>
            </div>
        </header>

        <div class="content__center-user">

            <ul class="content__center-user__list nav nav-tabs nav-fill" style="background: white">
                <li class="content__center-user__list__item nav-item">
                    <a class="content__center-user__list__item__hyperlink nav-link " href="costumerCreditRequestCredit.php">Solicitud de credito</a>
                </li>
                <li class="content__center-user__list__item nav-item">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Notificaciones
                    </button>
                    <div id='notif-budget' class="dropdown-menu">
                    </div>
                </li>

            </ul>
        </div>
        <div class='col text-center'>
            <h1>Créditos solicitados</h1>
        </div>
        <div class="content" id="customer-credits">

        </div>

    </div>
</body>

</html>