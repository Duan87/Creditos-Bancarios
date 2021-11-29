<?php

class CreditModel{

  private $id;
  private $creditKind;
  private $amount;
  private $fixedAmount;
  private $term;
  private $rate;

  function __construct(){}
/*
  function __construct($id,$type,$amount,$fixedAmount,$term,$rate){
    $this->id = $id;
    $this->type = $type;
    $this->amount = $amount;
    $this->fixedAmount = $fixedAmount;
    $this->term = $term;
    $this->rate = $rate;
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
     * Get the value of Amount
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of Amount
     *
     * @param mixed amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of Fixed Amount
     *
     * @return mixed
     */
    public function getFixedAmount()
    {
        return $this->fixedAmount;
    }

    /**
     * Set the value of Fixed Amount
     *
     * @param mixed fixedAmount
     *
     * @return self
     */
    public function setFixedAmount($fixedAmount)
    {
        $this->fixedAmount = $fixedAmount;

        return $this;
    }

    /**
     * Get the value of Term
     *
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set the value of Term
     *
     * @param mixed term
     *
     * @return self
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get the value of Rate
     *
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of Rate
     *
     * @param mixed rate
     *
     * @return self
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }


    /**
     * Get the value of Credit Type
     *
     * @return mixed
     */
    public function getCreditKind()
    {
        return $this->creditType;
    }

    /**
     * Set the value of Credit Type
     *
     * @param mixed creditType
     *
     * @return self
     */
    public function setCreditKind($creditKind)
    {
        $this->creditKind = $creditKind;

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
