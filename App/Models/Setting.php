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

        $sql = 'SELECT name, id
                FROM incomes_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

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
                FROM expenses_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    /**
     * Get payment method name and id from database
     * 
     * @return array
     */
    public static function getPaymentMethods() {

        $sql = 'SELECT name, id
                FROM payment_methods_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    /*public static function editIncomeName($newIncomeName) {

        $sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id,
                    amount, date_of_income, income_comment)
                VALUES (:user_id, :income_category_assigned_to_user_id,
                    :amount, :date_of_income, :income_comment)';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':income_category_assigned_to_user_id', Income::getIncomeCategoryId($newIncomeData['incomeCategory']), PDO::PARAM_INT);
        $stmt->bindValue(':amount', $newIncomeData['incomeAmount'], PDO::PARAM_STR);
        $stmt->bindValue(':date_of_income', $newIncomeData['incomeDate'], PDO::PARAM_STR);
        $stmt->bindValue(':income_comment', $newIncomeData['incomeComment'], PDO::PARAM_STR);

        return $stmt->execute();

    }*/
}
