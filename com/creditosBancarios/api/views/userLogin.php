<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-with, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/import/jquery-3.3.1.min.js"></script>
    <script src="assets/js/import/bootstrap.min.js"></script>
    <script src="assets/js/sumitDataUserType.js"></script>
    <script src="assets/js/validation.js"></script>
    <script src="assets/js/core.js"></script>
    <title></title>
</head>

<body>
    <div class="content container">
        <header class="content__header row">
            <div class="content__header__div-img-logo">
            </div>
        </header>
        <div class="content__center-login">
            <div class="content__center-login__logo-user">
            </div>
            <div class="content__center-login__frame col-8 ">
                <div class="alert alert-danger d-none" id="messageError">Contraseña o password invalidos</div>
                <form id="userLogin" onsubmit="return false" action="" method="post" class="content__center-login__frame__form">
                    <div class="content__center-login__frame__line-email row form-group">
                        <label for="nombre" class="content__center-login__frame__line col-form-label col-md-3">Correo de Usuario:</label>
                        <div class="col-md-8">
                            <input type="text" name="email" value="" id="email" class="content__center-login__frame__line-email__input-email--email form-control" minlength='1' maxlength='128' required>
                            <span class="content__center-login__frame__line-email__input-email__span-email help-block"></span>
                        </div>
                    </div>
                    <div class="content__center-login__frame__line-email row form-group">
                        <label for="email" class="content__center-login__frame__line col-form-label col-md-2">Contraseña:</label>
                        <div class="col-md-8">
                            <input onchange="validatePassword();" type="password" name="password" value="" id="password" class="content__center-login__frame__line__input-password--password form-control" minlength='1' maxlength='32' required>
                            <span class="content__center-login__frame__line__input__span-password help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button onClick="logUser();" id="btnLoginUser" name="btnLoginUser" class="content__center-login__frame__line-btn-login btn btn-info">Iniciar Sesión</button>
                        <br> <br >
                        Versión 3.0
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>