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
     * Get user incomes data from database
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return array
     */
    public static function getIncomesData($dateStart, $dateEnd) {

        $sql = 'SELECT income_category_assigned_to_user_id, amount, income_comment, date_of_income 
                FROM incomes
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
     * Get incomes category names and sum for specific names from database
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return array
     */
    public static function getIncomeNamesAndSum($dateStart, $dateEnd) {

        $sql = 'SELECT SUM(incomes.amount) as sumIncomeCategory, incomes_category_default.name, incomes_category_default.id
                FROM incomes, incomes_category_default
                WHERE user_id = :loggedUserId AND incomes.income_category_assigned_to_user_id = incomes_category_default.id AND date_of_income BETWEEN :dateStart AND :dateEnd
                GROUP BY incomes.income_category_assigned_to_user_id
                ORDER BY sumIncomeCategory DESC';

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
     * Get user expenses data from database
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return array
     */
    public static function getExpensesData($dateStart, $dateEnd) {

        $sql = 'SELECT expense_category_assigned_to_user_id, amount, expense_comment, date_of_expense 
                FROM expenses
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
     * Get expenses category names and sum for specific names from database
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return array
     */
    public static function getExpenseNamesAndSum($dateStart, $dateEnd) {

        $sql = 'SELECT SUM(expenses.amount) as sumExpenseCategory, expenses_category_default.name, expenses_category_default.id
                FROM expenses, expenses_category_default
                WHERE user_id = :loggedUserId AND expenses.expense_category_assigned_to_user_id = expenses_category_default.id AND date_of_expense BETWEEN :dateStart AND :dateEnd
                GROUP BY expenses.expense_category_assigned_to_user_id
                ORDER BY sumExpenseCategory DESC';

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
     * Get total incomes sum 
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return float
     */
    private static function getIncomesSum($dateStart, $dateEnd) {

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

            return floatval($incomesSum[0]);
    }

    /**
     * Get total expenses sum 
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return float
     */
    private static function getExpensesSum($dateStart, $dateEnd) {

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

                return floatval($expensesSum[0]);
    }

    /**
     * Calculate balance
     * 
     * @param string $dateStart as an parameter for sql query to pick records from specific time period
     * @param string $dateEnd as an parameter for sql query to pick records from specific time period
     * 
     * @return float
     */
        public static function calculateBalance($dateStart, $dateEnd) {

            $incomesSum = Balance::getIncomesSum($dateStart, $dateEnd);
            $expensesSum = Balance::getExpensesSum($dateStart, $dateEnd);
           
            $balance = $incomesSum - $expensesSum;

            return $balance;
        }
}
