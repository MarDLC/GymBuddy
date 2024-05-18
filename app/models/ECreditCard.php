<?php


class ECreditCard {

    //attributes
    private $idCreditCard;
    private $cvc;
    private $accountHolder;
    private $cardNumber;
    private $expirationDate;
    private $email;

    private static $entity = ECreditCard::class;

    //constructor
    public function __construct($cvc, $accountHolder, $cardNumber, $expirationDate, $email)
    {
        $this->cvc = $cvc;
        $this->accountHolder = $accountHolder;
        $this->cardNumber = $cardNumber;
        $this->expirationDate = $expirationDate;
        $this->email = $email;
    }

    //methods
    public static function getEntity(): string
    {
        return self::$entity;
    }

    public function getCvc()
    {
        return $this->cvc;
    }

    public function getAccountHolder()
    {
        return $this->accountHolder;
    }

    public function setAccountHolder($accountHolder)
    {
        $this->accountHolder = $accountHolder;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getIdCreditCard()
    {
        return $this->idCreditCard;
    }

    public function setIdCreditCard($idCreditCard)
    {
        $this->idCreditCard = $idCreditCard;
    }

}
