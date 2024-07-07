<?php

/**
 * Class FSubscription
 *
 * This class is responsible for managing subscriptions in the application.
 * It provides methods for creating, retrieving, updating, and deleting subscriptions.
 */
class FSubscription
{
    /**
     * @var string $table The name of the table in the database where the subscriptions are stored.
     */
    private static $table = "subscription";

    /**
     * @var string $value The value string used for binding parameters in SQL queries.
     */
    private static $value = "(:type,:duration,:price)";

    /**
     * @var string $key The key used for identifying subscriptions in the database.
     */
    private static $key = "email";

    /**
     * Get the name of the table where the subscriptions are stored.
     *
     * @return string The name of the table.
     */
    public static function getTable()
    {
        return self::$table;
    }

    /**
     * Get the value string used for binding parameters in SQL queries.
     *
     * @return string The value string.
     */
    public static function getValue()
    {
        return self::$value;
    }

    /**
     * Get the name of this class.
     *
     * @return string The name of this class.
     */
    public static function getClass()
    {
        return self::class;
    }

    /**
     * Get the key used for identifying subscriptions in the database.
     *
     * @return string The key.
     */
    public static function getKey()
    {
        return self::$key;
    }


    /**
     * Create an array of subscription objects from a query result.
     *
     * @param array $queryResult The result of a database query.
     * @return array An array of subscription objects.
     */
    public static function createSubscriptionObj($queryResult)
    {
        // Check if the query result is not empty
        if (count($queryResult) > 0) {
            // Initialize an empty array to hold the subscription objects
            $subscriptions = array();
            // Loop through each item in the query result
            for ($i = 0; $i < count($queryResult); $i++) {
                // Create a new subscription object with the type, duration, and price from the query result
                $sub = new ESubscription($queryResult[$i]['type'], $queryResult[$i]['duration'], $queryResult[$i]['price']);
                // Set the id of the subscription object
                $sub->setIdSubscription($queryResult[$i]['idSubscription']);
                // Set the email of the subscription object
                $sub->setEmail($queryResult[$i]['email']);
                // Add the subscription object to the array of subscriptions
                $subscriptions[] = $sub;
            }
            // Return the array of subscription objects
            return $subscriptions;
        } else {
            // If the query result is empty, return an empty array
            return array();
        }
    }

    /**
     * Bind the properties of a subscription object to a PDO statement.
     *
     * @param PDOStatement $stmt The PDO statement to bind the properties to.
     * @param ESubscription $subscription The subscription object whose properties are to be bound.
     */
    public static function bind($stmt, $subscription)
    {
        // Bind the email value from the subscription object to the ":email" parameter in the SQL statement
        $stmt->bindValue(":email", $subscription->getEmail(), PDO::PARAM_STR);

        // Bind the type value from the subscription object to the ":type" parameter in the SQL statement
        $stmt->bindValue(":type", $subscription->getType(), PDO::PARAM_STR);

        // Bind the duration value from the subscription object to the ":duration" parameter in the SQL statement
        $stmt->bindValue(":duration", $subscription->getDuration(), PDO::PARAM_INT);

        // Bind the price value from the subscription object to the ":price" parameter in the SQL statement
        $stmt->bindValue(":price", $subscription->getPrice(), PDO::PARAM_INT);
    }

    /**
     * Retrieve a subscription object from the database.
     *
     * @param string $email The email of the subscription to retrieve.
     * @return ESubscription|null The retrieved subscription object, or null if no subscription was found.
     */
    public static function getObj($id)
    {
        // Use the singleton instance of FEntityManagerSQL to retrieve the subscription object from the database
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);

        // Check if the result is not empty
        if (count($result) > 0) {
            // If the result is not empty, create a subscription object from the result
            $subscription = self::createSubscriptionObj($result);
            // Return the subscription object
            return $subscription;
        } else {
            // If the result is empty, return null
            return null;
        }
    }

    /**
     * Save a subscription object to the database.
     *
     * @param ESubscription $obj The subscription object to save.
     * @param array|null $fieldArray An optional array of fields to update. If null, all fields are updated.
     * @return bool True if the operation was successful, false otherwise.
     */
    public static function saveObj($obj, $fieldArray = null)
    {
        // If no specific fields are provided, save the entire object
        if ($fieldArray === null) {
            // Use the singleton instance of FEntityManagerSQL to save the subscription object to the database
            $saveSubscription = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            // If the save operation was successful, return the result
            if ($saveSubscription !== null) {
                return $saveSubscription;
            } else {
                // If the save operation was not successful, return false
                return false;
            }
        } else {
            // If specific fields are provided, only update those fields
            try {
                // Start a new database transaction
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                // Loop through each field-value pair in the provided array
                foreach ($fieldArray as $fv) {
                    // Update the specific field in the database
                    FEntityManagerSQL::getInstance()->updateObj(FSubscription::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdSubscription());
                }
                // Commit the transaction if all updates were successful
                FEntityManagerSQL::getInstance()->getDb()->commit();
                // Return true to indicate that the operation was successful
                return true;
            } catch (PDOException $e) {
                // Print the error message and rollback the transaction in case of an exception
                echo "ERROR " . $e->getMessage();
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
     * Delete a subscription from the database.
     *
     * @param string $email The email of the subscription to delete.
     * @return bool True if the operation was successful, false otherwise.
     */
    public static function deleteSubscription($id){
        try {
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Attempt to delete the subscription from the database
            $queryResult = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $id);

            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();

            // If the deletion was successful, return true
            if ($queryResult) {
                return true;
            } else {
                // If the deletion was not successful, return false
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