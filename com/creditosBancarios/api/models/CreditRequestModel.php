<?php
class CreditRequestModel{

  private $id;
  private $status;
  private $credit;
  private $applicant;

  function __construct(){}

    /*
  function __construct($id,$status,$credit,$applicant){
    $this->id = $id;
    $this->status = $status;
    $this->credit = $credit;
    $this->applicant = $applicant;
  }*/
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

    /**
     * Get the value of Status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of Status
     *
     * @param mixed status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of Credit
     *
     * @return mixed
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set the value of Credit
     *
     * @param mixed credit
     *
     * @return self
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get the value of Applicant
     *
     * @return mixed
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * Set the value of Applicant
     *
     * @param mixed applicant
     *
     * @return self
     */
    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;

        return $this;
    }

    public function toJson(){
      $json = array(
        "id" => $this->id,
        "status"=>$this->status,
        "customer"=>$this->applicant->toJson(),
        "credit"=>$this->credit->toJson()
      );
      return $json;
    }


}
 ?>
