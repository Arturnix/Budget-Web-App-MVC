<?php

namespace App\Models;

use PDO;
use \Core\View;
use \App\Models\Income;

/**
 * User model
 *
 * PHP version 7.0
 */

 #[\AllowDynamicProperties]
class Balance extends \Core\Model
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
     * Get user incomes from database
     * 
     * @return array
     */
    public static function getIncomes () {

        $sql = 'SELECT income_category_assigned_to_user_id, amount, income_comment, date_of_income FROM incomes
                WHERE user_id = :loggedUserId
                ORDER BY date_of_income asc';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

     /**
     * Get incomes category names from database
     * 
     * @return array
     */
    public static function getIncomeCategories () {

        $sql = 'SELECT * FROM incomes_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

    public static function getIncomeCategoriesId () {

        $sql = 'SELECT id FROM incomes_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

    public static function getIncomeForCategoryId () {

        $incomeSumForCategoryId = [];
        $incomeCategoryId = Balance::getIncomeCategoriesId();

        foreach ($incomeCategoryId as $id) {

            $sql = 'SELECT income_category_assigned_to_user_id, SUM(amount) as amount FROM incomes 
            WHERE income_category_assigned_to_user_id = :id AND user_id = :loggedUserId';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $stmt->execute();

            $incomeSumForCategoryId[] = $stmt->fetch();

        }

        return $incomeSumForCategoryId;
        }
    
    /**
     * Get user expenses from database
     * 
     * @return array
     */
    public static function getExpenses () {

        $sql = 'SELECT expense_category_assigned_to_user_id, amount, expense_comment, date_of_expense FROM expenses
                WHERE user_id = :loggedUserId
                ORDER BY date_of_expense asc';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    /**
     * Get expenses category names from database
     * 
     * @return array
     */
    public static function getExpenseCategories () {

        $sql = 'SELECT * FROM expenses_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

}
