<?php

/**
 * Class FCreditCard
 *
 * This class is responsible for handling operations related to the CreditCard entity.
 */
class FCreditCard
{

    /**
     * @var string $table The name of the table in the database.
     * This is used in SQL queries to specify the table to perform operations on.
     */
    private static $table = "creditcard";

    /**
     * @var string $value The value for the SQL query.
     * This is used in SQL queries to specify the values to be inserted into the table.
     */
    private static $value = "(NULL,:cvc,:accountHolder,:cardNumber,:expirationDate,:email)";

    /**
     * @var string $key The key for the SQL query.
     * This is used in SQL queries to specify the primary key of the table.
     */
    private static $key = "idCreditCard";

    /**
     * Get the table name.
     *
     * @return string The name of the table.
     * This method is used to get the name of the table for use in SQL queries.
     */
    public static function getTable()
    {
        return self::$table;
    }

    /**
     * Get the value for the SQL query.
     *
     * @return string The value for the SQL query.
     * This method is used to get the value for the SQL query for use in SQL queries.
     */
    public static function getValue()
    {
        return self::$value;
    }

    /**
     * Get the class name.
     *
     * @return string The name of the class.
     * This method is used to get the name of the class for use in SQL queries.
     */
    public static function getClass()
    {
        return self::class;
    }

    /**
     * Get the key for the SQL query.
     *
     * @return string The key for the SQL query.
     * This method is used to get the key for the SQL query for use in SQL queries.
     */
    public static function getKey()
    {
        return self::$key;
    }

    /**
     * Create a CreditCard object from a query result.
     *
     * @param array $queryResult The result of the query.
     * @return array An array of CreditCard objects if the query result is not empty, otherwise an empty array.
     */
    public static function createCreditCardObj($queryResult)
    {
        // Check if the query result is not empty
        if (count($queryResult) > 0) {
            // Initialize an empty array to hold the CreditCard objects
            $creditCard = array();
            // Loop through each item in the query result
            for ($i = 0; $i < count($queryResult); $i++) {
                // Create a new CreditCard object using the data from the query result
                $creditC = new ECreditCard($queryResult[$i]['cvc'], $queryResult[$i]['accountHolder'], $queryResult[$i]['cardNumber'], $queryResult[$i]['expirationDate'], $queryResult[$i]['email']);
                // Set the id of the CreditCard object
                $creditC->setIdCreditCard($queryResult[$i]['idCreditCard']);
                // Add the CreditCard object to the array
                $creditCard[] = $creditC;
            }
            // Return the array of CreditCard objects
            return $creditCard;
        } else {
            // If the query result is empty, return an empty array
            return array();
        }
    }

    /**
     * Bind the CreditCard parameters to the SQL statement.
     *
     * @param PDOStatement $stmt The SQL statement.
     * @param ECreditCard $creditCard The CreditCard object.
     */
    public static function bind($stmt, $creditCard)
    {
        // Bind the id of the CreditCard object to the ":idCreditCard" parameter in the SQL statement
        $stmt->bindValue(":idCreditCard", $creditCard->getIdCreditCard(), PDO::PARAM_INT);
        // Bind the cvc of the CreditCard object to the ":cvc" parameter in the SQL statement
        $stmt->bindValue(":cvc", $creditCard->getCvc(), PDO::PARAM_INT);
        // Bind the account holder of the CreditCard object to the ":accountHolder" parameter in the SQL statement
        $stmt->bindValue(":accountHolder", $creditCard->getAccountHolder(), PDO::PARAM_STR);
        // Bind the card number of the CreditCard object to the ":cardNumber" parameter in the SQL statement
        $stmt->bindValue(":cardNumber", $creditCard->getCardNumber(), PDO::PARAM_STR);
        // Bind the expiration date of the CreditCard object to the ":expirationDate" parameter in the SQL statement
        $stmt->bindValue(":expirationDate", $creditCard->getExpirationDate(), PDO::PARAM_STR);
        // Bind the email of the CreditCard object to the ":email" parameter in the SQL statement
        $stmt->bindValue(":email", $creditCard->getEmail(), PDO::PARAM_STR);
    }

    /**
     * Get a CreditCard object by id.
     *
     * @param int $idCreaditCard The id of the CreditCard.
     * @return ECreditCard|null A CreditCard object if found, otherwise null.
     */
    public static function getObj($idCreditCard)
    {
        // Use the singleton instance of FEntityManagerSQL to retrieve the CreditCard object from the database
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $idCreditCard);

        // Check if the result is not empty
        if (count($result) > 0) {
            // If the result is not empty, create a CreditCard object from the result
            $creditCard = self::createCreditCardObj($result);
            // Return the CreditCard object
            return $creditCard;
        } else {
            // If the result is empty, return null
            return null;
        }
    }

    /**
     * Save a CreditCard object to the database.
     *
     * @param ECreditCard $obj The CreditCard object to save.
     * @param array|null $fieldArray The fields to update.
     * @return bool|int The ID of the saved CreditCard object if successful, otherwise false.
     */
    public static function saveObj($obj, $fieldArray = null)
    {
        // Check if the fieldArray is null
        if ($fieldArray === null) {
            // If the fieldArray is null, save the CreditCard object to the database
            $saveCreditCard = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            // Check if the CreditCard object was saved successfully
            if ($saveCreditCard !== null) {
                // If the CreditCard object was saved successfully, return the ID of the saved CreditCard object
                return $saveCreditCard;
            } else {
                // If the CreditCard object was not saved successfully, return false
                return false;
            }
        } else {
            // If the fieldArray is not null, start a new database transaction
            try {
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                // Loop through each field in the fieldArray
                foreach ($fieldArray as $fv) {
                    // Update the field in the database
                    FEntityManagerSQL::getInstance()->updateObj(FCreditCard::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getCardNumber());
                }
                // Commit the transaction
                FEntityManagerSQL::getInstance()->getDb()->commit();
                // Return true to indicate that the operation was successful
                return true;
            } catch (PDOException $e) {
                // If an exception occurred, print the error message
                echo "ERROR " . $e->getMessage();
                // Rollback the transaction
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                // Return false to indicate that the operation was not successful
                return false;
            } finally {
                // Close the database connection
                FEntityManagerSQL::getInstance()->closeConnection();
            }
        }
    }

    /**
     * Delete a CreditCard from the database.
     *
     * @param int $idCreditCard The id of the CreditCard to delete.
     * @return bool True if the CreditCard was successfully deleted, otherwise false.
     */
    public static function deleteCreditCard($idCreditCard)
    {
        // Start a new database transaction
        try {
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Attempt to delete the CreditCard object from the database
            $queryResult = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $idCreditCard);
            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();
            // Check if the delete operation was successful
            if ($queryResult) {
                // If the delete operation was successful, return true
                return true;
            } else {
                // If the delete operation was not successful, return false
                return false;
            }
        } catch (PDOException $e) {
            // If an exception occurred, print the error message
            echo "ERROR " . $e->getMessage();
            // Rollback the transaction
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            // Return false to indicate that the operation was not successful
            return false;
        } finally {
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }
}