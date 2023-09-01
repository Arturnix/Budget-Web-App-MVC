<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */

 #[\AllowDynamicProperties]
class Setting extends \Core\Model
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Get income category name and id from database
     * 
     * @return array
     */
    public static function getIncomeName() {

        $sql = 'SELECT id, name
                FROM incomes_category_assigned_to_users
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    /**
     * Get expenses category names from database
     * 
     * @return array
     */
    public static function getExpenseName() {

        $sql = 'SELECT name
                FROM expenses_category_assigned_to_users
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    /**
     * Get payment method name and id from database
     * 
     * @return array
     */
    public static function getPaymentMethods() {

        $sql = 'SELECT id, name
                FROM payment_methods_assigned_to_users
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    public static function editIncomeName($newIncomeName) {

        $sql = 'UPDATE incomes_category_assigned_to_users
                SET name = :newName
                WHERE id = :oldName
                AND user_id = :loggedUserId';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':newName', $newIncomeName['newName'], PDO::PARAM_STR);
        $stmt->bindValue(':oldName', $newIncomeName['oldName'], PDO::PARAM_INT);
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
