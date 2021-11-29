<?php
  require_once(__DIR__.'/../database/DataBase.php');
  require_once(__DIR__.'/../../api/models/CreditModel.php');
  require_once(__DIR__.'/../../api/models/CreditRequestModel.php');
  require_once(__DIR__.'/../../api/models/CustomerModel.php');
  require_once(__DIR__.'/../../api/models/CustomerRefModel.php');

class EntityEmployee{

  public $db;

  function __construct(){
    $this->db = new DataBase();
  }

  public function searchRequests($email,$name){
    $resultArray = array();
    try{
      $this->db->connect();
      $query = "call sp_search_requests('".$email."','".$name."')";
      $query = $this->db->executeQuery($query);
      $dataResult = array();
      while($resultSet = $query->fetch_array(MYSQLI_ASSOC)){
        $dataResult[] = $resultSet;
      }
      $query->free();
      $this->db->disconnect();
      if($dataResult[0]["result"] == 1){
        foreach ($dataResult as $resultSet=>$row) {
          $creditRequestModel = new CreditRequestModel();
          //$referencesList = $this->processReferences($row);
          $credit = $this->processCredit($row);
          $customer = $this->processCustomer($row);

          $creditRequestModel->setId($row["id"]);
          $creditRequestModel->setStatus($row["state"]);
          $creditRequestModel->setCredit($credit);
          $creditRequestModel->setApplicant($customer);

          array_push($resultArray,$creditRequestModel->toJson());
        }
        $resultArray = json_encode(array(
            "result"=>$dataResult[0]["result"],
            "message" => $dataResult[0]["message"],
            "Requests"=>$resultArray
        ));
      }else
        $resultArray = json_encode(array("result"=>-1,"message"=>"No hay creditos pendientes con este mail y nombre"));

    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $resultArray;
  }

  public function dictaminate($requestId,$verdict){
    $resultArray = array();
    try{
      $this->db->connect();
      $query = "call sp_dictaminate(".$requestId.",".$verdict.")";
      //$query = $this->db->conn->prepare($query);
      $query = $this->db->executeQuery($query);
      $resultSet = $query->fetch_array(MYSQLI_ASSOC);
      if($resultSet > 0){
        $resultArray=  array("success"=>$resultSet["result"],"message"=>$resultSet["message"]);
      }else{
        $resultArray = array("success"=>-1,"message"=>"Error al procesar peticion");
      }
    }catch(Exception $e){
      echo $e->getMessage();
    }finally{
      $query->free();
      $this->db->disconnect();
    }
    return $resultArray;

  }

  public function approveCancellation($requestId,$employeeId,$pswd){
    $resultArray;
    try{
      $this->db->connect();
      $query = "call sp_approve_cancellation(".$employeeId.",'".$pswd."',".$requestId.")";
      //$query = $this->db->conn->prepare($query);
      $query = $this->db->executeQuery($query);
      $resultSet = $query->fetch_array(MYSQLI_ASSOC);
      if($resultSet > 0){
        $resultArray=  array("success"=>$resultSet["result"],"message"=>$resultSet["message"]);
      }
      $query->free();
      $this->db->disconnect();
    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $resultArray;
  }

  public function approveReconsideration($employeeId,$pswd,$email,$requestId,$isRenovation){
    $resultArray = array();
    try{
      $this->db->connect();
      $query = "call sp_approve_reconsideration(".$employeeId.",'".$pswd."','".$email."',".$requestId.")";
      //$query = $this->db->conn->prepare($query);
      $query = $this->db->executeQuery($query);
      $resultSet = $query->fetch_array(MYSQLI_ASSOC);
      if($resultSet > 0){
        $resultArray=  array("success"=>$resultSet["result"],"message"=>$resultSet["message"]);
      }
      $query->free();
      $this->db->disconnect();
    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $resultArray;
  }


  public function authorizeCreditRequest($employeeId,$pswd,$requestId){
    $resultArray = array();
    try{
      $this->db->connect();
      $query = "call sp_credit_authorization(".$employeeId.",'".$pswd."',".$requestId.")";
      //$query = $this->db->conn->prepare($query);
      $query = $this->db->executeQuery($query);
      $resultSet = $query->fetch_array(MYSQLI_ASSOC);
      if($resultSet > 0){
        $resultArray=  array("success"=>$resultSet["result"],"message"=>$resultSet["message"]);
      }
      $query->free();
      $this->db->disconnect();
    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $resultArray;
  }

  public function setInvestigationResult($requestId,$arrayReferences){
    $resultArray = array();
    $firstRef = $arrayReferences[0];
    $secondRef = $arrayReferences[1];
    try{
      $this->db->connect();
      $query = "call sp_set_reference_remark(".$firstRef["id"].",'".$firstRef["remark"]."')";
      //$query = $this->db->conn->prepare($query);
      $query = $this->db->executeQuery($query);
      $query = "call sp_set_reference_remark(".$secondRef["id"].",'".$secondRef["remark"]."')";
      //$query = $this->db->conn->prepare($query);
      $query = $this->db->executeQuery($query);
      $query = "update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Dictaminacion') where pk_request_id =".$requestId."";
      $query = $this->db->executeQuery($query);
      $resultArray = array("success"=>1,"message"=>"Resultados de investigacion enviados");
      $this->db->disconnect();
    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $resultArray;

  }

  public function getRequest($requestId){
    $resultArray = array();
    try{
      $this->db->connect();
      $query = "select * from vw_credits where id =".$requestId."";
      $query = $this->db->executeQuery($query);
      $resultSet = $query->fetch_array(MYSQLI_ASSOC);
      if($resultSet > 0){
        $resultArray = $resultSet;
        $query = "call sp_get_customer_references(".$requestId.")";
        $query = $this->db->executeQuery($query);
        $references = array();
        while($resultSet = $query->fetch_array(MYSQLI_ASSOC)){
          array_push($references,$resultSet);
        }
        $resultArray = json_encode(array(
          "result"=>1,"message"=>"Solicitud encontrada",
          "request"=>$resultArray,
          "references"=>$references
        ));

      }else {
        $resultArray= json_encode(array("result"=>0,"message"=>"No se encontro solicitud"));
      }
    }catch(Exception $e){
      echo $e->getMessage();
    }finally{
      $query->free();
      $this->db->disconnect();
    }
    return $resultArray;
  }


  public function getAllPendingRequests($employeeId,$onlyReconsiderations){
    $resultArray = array();
    try{
      $this->db->connect();
      if($onlyReconsiderations)
        $query = "call sp_get_reconsiderations_pending(".$employeeId.")";
      else
        $query = "call sp_get_pending_credits(".$employeeId.")";

      $query = $this->db->executeQuery($query);
      $dataResult = array();
      while($resultSet = $query->fetch_array(MYSQLI_ASSOC)){
          $dataResult[] = $resultSet;
      }
    $query->free();
    $this->db->disconnect();
        if($dataResult[0]["result"] == 1){
        foreach ($dataResult as $resultSet=>$row) {
          $creditRequestModel = new CreditRequestModel();
          //$referencesList = $this->processReferences($row);
          $credit = $this->processCredit($row);
          $customer = $this->processCustomer($row);

          $creditRequestModel->setId($row["id"]);
          $creditRequestModel->setStatus($row["state"]);
          $creditRequestModel->setCredit($credit);
          $creditRequestModel->setApplicant($customer);

          array_push($resultArray,$creditRequestModel->toJson());
        }
        $resultArray = json_encode(array(
                "result"=>$dataResult[0]["result"],
                "message" => $dataResult[0]["message"],
                "Requests"=>$resultArray
              ));
      }else
       $resultArray = json_encode(array("result"=>-1,"message"=>"No hay creditos pendientes"));

    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $resultArray;
  }

  /*
    Quitar esta función

    private function processReferences($resultSet){
    $this->db->connect();
    $query = "call sp_get_customer_references(".$resultSet["customer_id"].")";
    $query = $this->db->executeQuery($query);
    $referencesList = array();

    while($references = $query->fetch_array(MYSQLI_ASSOC)){
      $customerReference = new CustomerRefModel();
      $customerReference->setName($references["name"]);
      $customerReference->setFirstSurname($references["first_surname"]);
      $customerReference->setSecondSurname($references["second_surname"]);
      $customerReference->setTelephone($references["telephone"]);
      $customerReference->setTimeMeeting($references["timeMeeting"]);
      $customerReference->setRemark($references["remark"]);
      array_push($referencesList,$customerReference);
      $query->free();
    }
    $this->db->disconnect();
    return $referencesList;
  }*/

  private function processCustomer($resultSet){
    $customerModel = new CustomerModel();
    $customerModel->setId($resultSet["customer_id"]);
    $customerModel->setFullname($resultSet["customer"]);
    $customerModel->setEmail($resultSet["mail"]);
    $customerModel->setStreet($resultSet["street"]);
    $customerModel->setHouseNumber($resultSet["house_number"]);
    $customerModel->setTelephone($resultSet["telephone"]);
    $customerModel->setRfc($resultSet["rfc"]);
    $customerModel->setCurp($resultSet["curp"]);
    $customerModel->setJob($resultSet["job"]);
    $customerModel->setCompany($resultSet["company"]);
    $customerModel->setSalary($resultSet["salary"]);
    return $customerModel;
  }

  private function processCredit($resultSet){
    $creditModel = new CreditModel();
    $creditModel->setTerm($resultSet["term"]);
    $creditModel->setCreditKind($resultSet["credit_name"]);
    $creditModel->setRate($resultSet["rate"]);
    $creditModel->setFixedAmount($resultSet["fixed_amount"]);
    $creditModel->setAmount($resultSet["amount"]);
    return $creditModel;
  }

}


?>
