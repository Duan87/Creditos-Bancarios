<?php

class UserModel{

  protected $fullname;
  protected $name;
  protected $firstSurname;
  protected $secondSurname;
  protected $telephone;
  protected $houseNumber;
  protected $street;
  protected $email;
  protected $password;
  protected $userType;
  protected $id;

  function __construct(){}

    /*
  function __construct($fullname,$telephone,$street,$email,$password,$userType,$id,$houseNumber){
    $this->fullname = $fullname;
    $this->telephone = $telephone;
    $this->street = $street;
    $this->email = $email;
    $this->password = $password;
    $this->userType = $userType;
    $this->id = $id;
    $this->houseNumber = $houseNumber;
  }
*/



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
     * Get the value of Street
     *
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of Street
     *
     * @param mixed street
     *
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of Password
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of Password
     *
     * @param mixed password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of User Type
     *
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set the value of User Type
     *
     * @param mixed userType
     *
     * @return self
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

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
     * Get the value of Fullname
     *
     * @return mixed
     */
    public function getFullname()
    {
        return $this->name." ".$this->firstSurname." ".$this->secondSurname;
    }

    /**
     * Set the value of Fullname
     *
     * @param mixed fullname
     *
     * @return self
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }



    /**
     * Get the value of House Number
     *
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set the value of House Number
     *
     * @param mixed houseNumber
     *
     * @return self
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

}

 ?>
