<?php

require_once(__DIR__ . '/../../util/entities/EntityCustomer.php');

class CustomerController
{

    public $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function requestCredit()
    {
        //Instanciacion.2
        $customer = new EntityCustomer();
        session_start();
        $customerId = $_SESSION["user"];
        $credit = $this->request["creditId"];
        $amount = $this->request["amount"];
        $references = array_values($this->request["references"]);
        $response = json_encode($customer->addCredit($credit, $customerId, $references, $amount));
        echo $response;
    }

    public function requestReconsideration()
    {
        $customer = new EntityCustomer();
        session_start();
        $customerId = $_SESSION["user"];
        $creditId = $this->request["creditId"];
        $response = json_encode($customer->reconsiderateCredit($creditId, $customerId));
        echo $response;
    }

    public function requestRenovation()
    {
        $customer = new EntityCustomer();
        $creditId = $this->request["creditId"];
        $response = json_encode($customer->renovateCredit($creditId));
        echo $response;
    }

    public function requestCancellation()
    {
        $customer = new EntityCustomer();
        session_start();
        $creditId = $this->request["creditId"];
        $customerId = $_SESSION["user"];
        $response = json_encode($customer->cancelCredit($creditId, $customerId));
        echo $response;
    }

    public function getCustomerData()
    {
        $customer = new EntityCustomer();
        session_start();
        $customerId = $_SESSION["user"];
        $creditsData = $customer->getCredits($customerId);
        $notifications = $customer->getNotifications($customerId);
        echo json_encode(array(
            "credits" => $creditsData,
            "notifications" => $notifications
        ));
    }
}



$request_type = $_POST["action"];
$controller = new CustomerController($_POST); //Guardamos el request recibido
switch ($request_type) {

    case "addCredit":
        $controller->requestCredit(); //Llamamos al método correspondiente
        break;
    case "reconsideration":
        $controller->requestReconsideration();
        break;
    case "renovation":
        $controller->requestRenovation();
        break;
    case "cancellation":
        $controller->requestCancellation();
        break;
    case "getCustomerData":
        $controller->getCustomerData();
        break;
    default:
        echo json_encode(array("message" => "Servicio no disponible"));
}
