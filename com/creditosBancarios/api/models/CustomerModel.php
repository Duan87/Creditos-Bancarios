<?php
require_once('UserModel.php');

class CustomerModel extends UserModel{

  private $customerId;
  private $rfc;
  private $curp;
  private $company;
  private $job;
  private $salary;
  private $referencesList;

  function __construct(){}

    /*
  function __construct($name,$telephone,$street,$email,$password,$userType,$userId,$id,
  $rfc,$curp,$company,$job,$salary,$referencesList){
    parent::__construct($fullname,$telephone,$street,$email,$password,$userType,$userId);
    $this->customerId = $id;
    $this->rfc = $rfc;
    $this->curp = $curp;
    $this->company = $company;
    $this->job = $job;
    $this->salary = $salary;
    $this->referencesList = $referencesList;
  }*/
    /**
     * Get the value of Rfc
     *
     * @return mixed
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set the value of Rfc
     *
     * @param mixed rfc
     *
     * @return self
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get the value of Curp
     *
     * @return mixed
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set the value of Curp
     *
     * @param mixed curp
     *
     * @return self
     */
    public function setCurp($curp)
    {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get the value of Company
     *
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of Company
     *
     * @param mixed company
     *
     * @return self
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of Job
     *
     * @return mixed
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of Job
     *
     * @param mixed job
     *
     * @return self
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get the value of Salary
     *
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set the value of Salary
     *
     * @param mixed salary
     *
     * @return self
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get the value of References List
     *
     * @return mixed
     */
    public function getReferencesList()
    {
        return $this->referencesList;
    }

    /**
     * Set the value of References List
     *
     * @param mixed referencesList
     *
     * @return self
     */
    public function setReferencesList($referencesList)
    {
        $this->referencesList = $referencesList;

        return $this;
    }


    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /*
    Retorna las variables del objeto para que sobre ellas pueda aplicarse
    el método json_encode
    */
    public function toJson(){
      return get_object_vars($this);
    }

}
 ?>
