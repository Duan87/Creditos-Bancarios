<?php
  require_once(__DIR__.'/../../api/config/UserTypes.php');
  require_once(__DIR__.'/../database/DataBase.php');

class EntityUser{

    public $db;
    //constructor
    function __construct(){
      $this->db=new Database();
    }

      public function addUSer(){

      }

      public function updateUser(){

      }

      public function deleteUser(){

      }

      public function getUser(){

      }

      public function logUser($mail,$pswd){
        $resultArray;
        try{
          $this->db->connect();
          $query = "call sp_log_in('".$mail."','".$pswd."')";
          //$query = $this->db->conn->prepare($query);
          $query = $this->db->executeQuery($query);
          $resultSet = $query->fetch_array(MYSQLI_ASSOC);
          if($resultSet > 0){
            $result = $resultSet["id"];
            $message = $resultSet["message"];
            if($result != -1){ // Usuario  encontrado
              $userType = $resultSet["user_type"];
              $userName = $resultSet["user_name"];
              $view = $this->openUserSession($result,$userType,$userName);
              $resultArray = array("result"=>1,"message"=>$message,"view"=>$view);
            }else{
              $resultArray = array("result"=>$result,"message"=>$message);
            }
          }
          $query->free();
          $this->db->disconnect();

        }catch(Exception $e){
          echo $e->getMessage();
        }
        return $resultArray;
      }

      public function isValidUser(){

      }

      private function openUserSession($id,$userType,$userName){
        $view = null;
        session_start();
        $_SESSION["user"] = $id;
        $_SESSION["userType"] = $userType;
        $_SESSION["userName"] = $userName;
        switch ($userType){
          case UserTypes::CUSTOMER:
            $view = "costumerViews.php";
            break;
          case UserTypes::MANAGER:
            $view = 'managerialPendingRequest.php';
            break;
          default: $view = 'employeePendingRequest.php';
        }
        return $view;
      }
  }
 ?>
