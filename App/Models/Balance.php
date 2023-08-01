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
    public static function getIncomes($dateStart, $dateEnd) {

        $sql = 'SELECT income_category_assigned_to_user_id, amount, income_comment, date_of_income FROM incomes
                WHERE user_id = :loggedUserId AND date_of_income BETWEEN :dateStart AND :dateEnd
                ORDER BY date_of_income ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
        $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

     /**
     * Get incomes category names from database
     * 
     * @return array
     */
    //Sprawdzić czy tutaj potrzeba daty
    public static function getIncomeCategories($dateStart, $dateEnd) {

        $sql = 'SELECT DISTINCT incomes_category_default.name, incomes_category_default.id FROM incomes_category_default
                INNER JOIN incomes ON incomes_category_default.id = incomes.income_category_assigned_to_user_id
                WHERE incomes.user_id = :loggedUserId AND date_of_income BETWEEN :dateStart AND :dateEnd
                ORDER BY incomes.amount DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
        $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

    public static function getIncomeCategoriesId() {

        $sql = 'SELECT id FROM incomes_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

    public static function getIncomeForCategoryId($dateStart, $dateEnd) {

        $incomeSumForCategoryId = [];
        $incomeCategoryId = Balance::getIncomeCategoriesId();

        foreach ($incomeCategoryId as $id) {

            $sql = 'SELECT income_category_assigned_to_user_id, SUM(amount) as amount FROM incomes 
            WHERE income_category_assigned_to_user_id = :id AND user_id = :loggedUserId AND date_of_income BETWEEN :dateStart AND :dateEnd';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
            $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

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
    public static function getExpenses($dateStart, $dateEnd) {

        $sql = 'SELECT expense_category_assigned_to_user_id, amount, expense_comment, date_of_expense FROM expenses
                WHERE user_id = :loggedUserId AND date_of_expense BETWEEN :dateStart AND :dateEnd
                ORDER BY date_of_expense ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
        $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomes = $stmt->fetchAll();
    }

    /**
     * Get expenses category names from database
     * 
     * @return array
     */
    public static function getExpenseCategories($dateStart, $dateEnd) {

        $sql = 'SELECT DISTINCT expenses_category_default.name, expenses_category_default.id FROM expenses_category_default
                INNER JOIN expenses ON expenses_category_default.id = expenses.expense_category_assigned_to_user_id
                WHERE expenses.user_id = :loggedUserId AND date_of_expense BETWEEN :dateStart AND :dateEnd
                ORDER BY expenses.amount DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
        $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

    public static function getExpenseCategoriesId() {

        $sql = 'SELECT id FROM expenses_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->execute();

        return $incomeId = $stmt->fetchAll();
    }

    public static function getExpenseForCategoryId($dateStart, $dateEnd) {

        $expenseSumForCategoryId = [];
        $expenseCategoryId = Balance::getExpenseCategoriesId();

        foreach ($expenseCategoryId as $id) {

            $sql = 'SELECT expense_category_assigned_to_user_id, SUM(amount) as amount FROM expenses 
            WHERE expense_category_assigned_to_user_id = :id AND user_id = :loggedUserId AND date_of_expense BETWEEN :dateStart AND :dateEnd';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
            $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $stmt->execute();

            $expenseSumForCategoryId[] = $stmt->fetch();

        }

        return $expenseSumForCategoryId;
    }

        public static function calculateBalance($dateStart, $dateEnd) {

            $sql = 'SELECT SUM(amount) as amount FROM expenses 
            WHERE user_id = :loggedUserId AND date_of_expense BETWEEN :dateStart AND :dateEnd';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
            $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_NUM);

            $stmt->execute();

            $expensesSum = $stmt->fetch();
            $expensesSum = floatval($expensesSum[0]);

            $sql = 'SELECT SUM(amount) as amount FROM incomes 
            WHERE user_id = :loggedUserId AND date_of_income BETWEEN :dateStart AND :dateEnd';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
            $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_NUM);

            $stmt->execute();

            $incomesSum = $stmt->fetch();
            $incomesSum = floatval($incomesSum[0]);
           
            $balance = $incomesSum - $expensesSum;

            return $balance;
        }

}
