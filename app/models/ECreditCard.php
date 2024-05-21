<?php

/**
 * Class ECreditCard
 *
 * This class represents a credit card in the application.
 * It includes properties for id, cvc, account holder, card number, expiration date, and email.
 * It also includes methods for getting and setting these properties.
 */
class ECreditCard {

    /**
     * @var int $idCreditCard The ID of the credit card.
     */
    private $idCreditCard;

    /**
     * @var int $cvc The CVC of the credit card.
     */
    private $cvc;

    /**
     * @var string $accountHolder The account holder of the credit card.
     */
    private $accountHolder;

    /**
     * @var string $cardNumber The card number of the credit card.
     */
    private $cardNumber;

    /**
     * @var string $expirationDate The expiration date of the credit card.
     */
    private $expirationDate;

    /**
     * @var string $email The email associated with the credit card.
     */
    private $email;

    /**
     * @var string $entity The name of the class. This is set to ECreditCard::class.
     */
    private static $entity = ECreditCard::class;

    /**
     * Constructor for the ECreditCard class.
     *
     * @param int $cvc The CVC of the credit card.
     * @param string $accountHolder The account holder of the credit card.
     * @param string $cardNumber The card number of the credit card.
     * @param string $expirationDate The expiration date of the credit card.
     * @param string $email The email associated with the credit card.
     */
    public function __construct($cvc, $accountHolder, $cardNumber, $expirationDate, $email)
    {
        $this->cvc = $cvc;
        $this->accountHolder = $accountHolder;
        $this->cardNumber = $cardNumber;
        $this->expirationDate = $expirationDate;
        $this->email = $email;
    }

    /**
     * Get the name of the class.
     *
     * @return string The name of the class.
     */
    public static function getEntity(): string
    {
        return self::$entity;
    }

    /**
     * Get the CVC of the credit card.
     *
     * @return int The CVC of the credit card.
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * Get the account holder of the credit card.
     *
     * @return string The account holder of the credit card.
     */
    public function getAccountHolder()
    {
        return $this->accountHolder;
    }

    /**
     * Set the account holder of the credit card.
     *
     * @param string $accountHolder The new account holder of the credit card.
     */
    public function setAccountHolder($accountHolder)
    {
        $this->accountHolder = $accountHolder;
    }

    /**
     * Get the card number of the credit card.
     *
     * @return string The card number of the credit card.
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set the card number of the credit card.
     *
     * @param string $cardNumber The new card number of the credit card.
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * Get the expiration date of the credit card.
     *
     * @return string The expiration date of the credit card.
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set the expiration date of the credit card.
     *
     * @param string $expirationDate The new expiration date of the credit card.
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * Get the email associated with the credit card.
     *
     * @return string The email associated with the credit card.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the email associated with the credit card.
     *
     * @param string $email The new email associated with the credit card.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the ID of the credit card.
     *
     * @return int The ID of the credit card.
     */
    public function getIdCreditCard()
    {
        return $this->idCreditCard;
    }

    /**
     * Set the ID of the credit card.
     *
     * @param int $idCreditCard The new ID of the credit card.
     */
    public function setIdCreditCard($idCreditCard)
    {
        $this->idCreditCard = $idCreditCard;
    }

}