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
class Income extends \Core\Model
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
     * @param array $data  Initial property values (optional)
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
     * Get income categories from database
     * 
     * @return array
     */
    /*public static function getIncomeCategoriesDefault () {

        $sql = 'SELECT * FROM incomes_category_default
                ORDER BY id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 1);

        $stmt->execute();

        return $incomeCategoriesDefault = $stmt->fetchAll();
    }*/

    /**
     * Get income categories from database
     * 
     * @return array
     */
    public static function getIncomeCategoriesAssignedToUser() {

        $sql = 'SELECT name FROM incomes_category_assigned_to_users
                WHERE user_id = :loggedUserId
                ORDER BY id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $incomeCategoriesDefault = $stmt->fetchAll();
    }

    /**
     * Extract id of picked income category
     * 
     * @param string $incomeCategoryName subbmited by user
     * 
     * @return int $incomeCategoryId category id corresponding with subbmited category name
     */
    private static function getIncomeCategoryId ($incomeCategoryName) {

        $sql = 'SELECT id FROM incomes_category_assigned_to_users 
                WHERE user_id = :loggedUserId AND name = :incomeCategoryName';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':incomeCategoryName', $incomeCategoryName, PDO::PARAM_STR);

        $stmt->execute();

        return $incomeCategoryId = $stmt->fetch();
    }

    /**
     * Creating sql statement and add new income record to database
     * 
     * @param array $newIncomeData income data subbmited by user
     * 
     * @return mixed User object if found, false otherwise
     */
    public static function transferNewIncomeData ($newIncomeData) {

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
    }
}
