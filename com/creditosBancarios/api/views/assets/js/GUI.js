/*
  Se encarga del despliegue y el procesamiento de los datos
  que se reciben del servidor para poder mostrar las
  solicitudes pendientes
*/
function renderPendingRequests() {
    let html = "";
    $.post(
        "../../api/controllers/EmployeeController.php", {
            action: "pendingRequests",
        },
        function (response) {
            console.log(response);
            response = $.parseJSON(response);
            if ((response.result = 1)) {
                html = processPendingRequests(response.Requests);
                $("body").ready($("#requestsTable").append(html));
            } else alert(response.message);
        }
    );
}

function getAllReconsiderationsRequests(){
    let html = "";
    $.post(
        "../../api/controllers/EmployeeController.php", {
            action: "pendingReconsiderationRequests",
        },
        function (response) {
            console.log(response);
            response = $.parseJSON(response);
            if ((response.result = 1)) {
                html = processPendingRequests(response.Requests);
                $("body").ready($("#reconsiderationsTable").append(html));
            } else alert(response.message);
        }
    );
}

function searchRequests(){
    let searchedMail = $("#searchedEmail").val();
    let searchedName = $("#searchedName").val();
    if(isValidSearchRequest(searchedMail,searchedName)){
        $.post(
            "../../api/controllers/EmployeeController.php",{
                action:"searchRequests",email:searchedMail,name:searchedName,
            },
            function (response) {
                console.log(response);
                response = $.parseJSON(response);
                if(response.result == 1){
                    html = processPendingRequests(response.Requests);
                    $("#requestsTable > tbody").remove();
                    $("body").ready($("#requestsTable").append(html));
                }else
                    alert(response.result);
            }
        );
    }

}

function isValidSearchRequest(mail,name){
    try{
        if(mail.match("^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$")== null)
            throw new Error("Debes escribir un email y en formato válido: algo@ejemplo.com");
        if(name.match("[a-zA-Z\\s]{1,64}")== null)
            throw new Error("Es necesario proporcionar un nombre. Sólo se permiten letras y una longitud máxima de 64 caracteres");
        else
            if(name.match("[a-zA-Z]+") == null) //No hay al menos una letra
                throw new Error("Debe haber letras en el nombre");
    }catch (e){
        alert(e);
        return false;
    }
    return true;
}

/*
  Se encarga del procesamiento del json que contiene las request pendientes
  para poder pasarlo a html
*/
function processPendingRequests(requests) {
    let request = null;
    let html = "<tbody>";
    let credit = null;
    let customer = null;
    $.each(requests, function (index, value) {
        request = value;
        credit = request.credit;
        customer = request.customer;
        html += "<tr data-request=" + request.id + ">";
        html +=
            '<td><button onClick="processRequest(this);" class="content__header__user__col__btn btn btn-primary">Procesar</button></td>';
        html += "<td>" + customer.fullname + "</td>";
        html += "<td>" + credit.creditKind + "</td>";
        html += "<td>" + credit.amount + "</td>";
        html += "<td>" + credit.fixedAmount + "</td>";
        html += "<td>" + credit.term + "</td>";
        html += "<td>" + credit.rate + "</td>";
        html += "<button onclick=''";
        html += "</tr>";
    });
    return (html += "</tbody>");
}

/*
    Realiza la petición al servidor de los créditos solicitados
    y las notificaciones del cliente.
*/
function renderCustomerData(showCredits) {
    let creditList = null;
    let notifications = null;
    $.post(
        "../../api/controllers/CustomerController.php", {
            action: "getCustomerData",
        },
        function (response) {
            console.log(response);
            response = $.parseJSON(response);
            if (showCredits) {
                creditList = response.credits;
                processCredits(creditList);
            }
            notifications = response.notifications;
            processNotifications(notifications);
        }
    );
}

/*
  Extrae cada una de las notificationes contenida en la lista
  y las procesa para insertarlas como html
*/
function processNotifications(notifList) {
    let html = "";
    let notification = null;
    if (notifList.hasNotifications) {
        html += "<ul class='list-group'>";
        $.each(notifList.notificationList, function (index, value) {
            notification = value;
            html += "<li class='list-group-item'><span class='dropdown-item-text'>";
            html +=
                "<h5>Actualización de estado</h5> \nSolicitud: " +
                notification.request +
                "\n";
            html += "<br>Estatus:" + notification.state;
            html += "<br><small>" + notification.date + "</small>";
            html += "</span></li>";
        });
        html += "</ul>";
    } else {
        html = "No hay notificaciones";
    }
    $("body").ready(function () {
        $("#notif-budget").html(html);
    });
}

/*
  Extrae cada los datos de cada crédito
  y lo procesa para insertarlo como html
*/
function processCredits(creditList) {
    let html = "";
    let credit = null;
    if (creditList.hasCredits) {
        $.each(creditList.creditList, function (index, value) {
            credit = value;
            html +=
                "<div class='jumbotron' data-request=" +
                credit.id +
                " id='credit_" +
                credit.id +
                "'>";
            html += "<ul class='list-group'>";
            html += "<dl>";
            html += "<li class='list-group-item'>";
            html += "<dt>Tipo</dt><dd>-" + credit.creditKind + "</dd>";
            html += "<dt>Monto fijo</dt><dd>-" + credit.fixedAmount + "</dd>";
            html += "<dt>Monto</dt><dd>-" + credit.amount + "</dd>";
            html += "<dt>Plazo</dt><dd>-" + credit.term + "</dd>";
            html += "<dt>Tasa de interés</dt><dd>-" + credit.rate + "</dd>";
            html +=
                "<dt>Estatus de crédito:</dt><dd>-" + credit.status + "</dd></dl>";
            html += appendCreditActions(credit.status, credit.id);
            html += "</li>";
            html += "</ul></div><div class='divider'></div>";
        });
    } else {
        html = "<div class='container'>Aún no tienes créditos solicitados</div>";
    }
    $("body").ready($("#customer-credits").html(html));
}

function appendCreditActions(creditStatus, creditId) {
    let html = "";
    html += "<div class='row'>";
    if (creditStatus != "Cancelacion" && creditStatus != "Rechazo" && creditStatus != "Pendiente de cancelacion")
        html +=
        "<button onclick='requestCancellation(this);' class='content__center-user__div-data__btn btn btn-primary'>Cancelar</button>";
    if (creditStatus == "Aprobado")
        html +=
        "<button onclick='requestRenovation(this);' class='content__center-user__div-data__btn btn btn-primary'>Renovar</button>";
    if (creditStatus == "Rechazo")
        html +=
        "<button onclick='requestReconsideration(" + creditId + ");' class='content__center-user__div-data__btn btn btn-primary'>Reconsiderar</button>";
    html += "</div>";
    return html;
}