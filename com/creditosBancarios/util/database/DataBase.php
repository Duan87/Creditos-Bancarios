<?php


class DataBase{

  // specify your own database credentials
   private $host = "localhost";
   private $db_name = "creditsDB";
   private $user = "root";
   private $pass = "Fernando_87";
   public $conn;

   function __construct(){}

   public function connect()
  {
    try{
        $this->conn =  new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        // Check connection
        if ($this->conn->connect_errno) {
          throw new Exception("Fallo al conectar con la base de datos: " .$this->conn->connect_error);
        }
      }catch(Exception $e){
        throw new Exception($e->getMessage());
      }
  }

    public function disconnect()
      {
          $this->conn->close();
      }

   public function executeQuery($query){
     $query = $this->conn->query($query,MYSQLI_STORE_RESULT);
     if($query == false)
         echo mysqli_error($this->conn);
     return $query;
   }
}
/**/
 ?>
