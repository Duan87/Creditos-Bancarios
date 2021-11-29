<?php
class CustomerRefModel{

  private $id;
  private $referencedRequest;
  private $name;
  private $firstSurname;
  private $secondSurname;
  private $telephone;
  private $timeMeeting;
  private $remark;

  function __construct(){}

    /*
  function __construct($id,$referencedRequest,$name,$firstSurname,$secondSurname,$telephone,$timeMeeting,$remark){
    $this->id = $id;
    $this->referencedRequest = $referencedRequest;
    $this->name = $name;
    $this->firstSurname = $firstSurname;
    $this->secondSurname = $secondSurname;
    $this->telephone = $telephone;
    $this->timeMeeting = $timeMeeting;
    $this->remark = $remark;
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
     * Get the value of Referenced Customer
     *
     * @return mixed
     */
    public function getReferencedRequest()
    {
        return $this->referencedRequest;
    }

    /**
     * Set the value of Referenced Customer
     *
     * @param mixed referencedCustomer
     *
     * @return self
     */
    public function setReferencedRequest($referencedRequest)
    {
        $this->referencedRequest = $referencedRequest;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of First Surname
     *
     * @return mixed
     */
    public function getFirstSurname()
    {
        return $this->firstSurname;
    }

    /**
     * Set the value of First Surname
     *
     * @param mixed firstSurname
     *
     * @return self
     */
    public function setFirstSurname($firstSurname)
    {
        $this->firstSurname = $firstSurname;

        return $this;
    }

    /**
     * Get the value of Second Surname
     *
     * @return mixed
     */
    public function getSecondSurname()
    {
        return $this->secondSurname;
    }

    /**
     * Set the value of Second Surname
     *
     * @param mixed secondSurname
     *
     * @return self
     */
    public function setSecondSurname($secondSurname)
    {
        $this->secondSurname = $secondSurname;

        return $this;
    }

    /**
     * Get the value of Telephone
     *
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of Telephone
     *
     * @param mixed telephone
     *
     * @return self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of Time Meeting
     *
     * @return mixed
     */
    public function getTimeMeeting()
    {
        return $this->timeMeeting;
    }

    /**
     * Set the value of Time Meeting
     *
     * @param mixed timeMeeting
     *
     * @return self
     */
    public function setTimeMeeting($timeMeeting)
    {
        $this->timeMeeting = $timeMeeting;

        return $this;
    }

    /**
     * Get the value of Remark
     *
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set the value of Remark
     *
     * @param mixed remark
     *
     * @return self
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

} ?>
