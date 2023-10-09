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
class Expense extends \Core\Model
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
     * Get payment methods assigned to logged user from database
     * 
     * @return array
     */
    public static function getPaymentMethodsAssignedToUser() {

        $sql = 'SELECT name FROM payment_methods_assigned_to_users
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $paymentMethodsDefault = $stmt->fetchAll();
    }

    /**
     * Get expenses categories assigned to logged user from database
     * 
     * @return array
     */
    public static function getExpenseCategoriesAssignedToUser() {
        
        $sql = 'SELECT name FROM expenses_category_assigned_to_users 
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $expenseCategoriesDefault = $stmt->fetchAll();
    }

    /**
     * Extract id of picked expanse category
     * 
     * @param string $expenseCategoryName subbmited by user
     * 
     * @return int $expenseCategoryId category id corresponding with subbmited category name
     */
    private static function getExpenseCategoryId($expenseCategoryName) {

        $sql = 'SELECT id FROM expenses_category_assigned_to_users 
                WHERE user_id = :loggedUserId AND name = :expenseCategoryName';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':expenseCategoryName', $expenseCategoryName, PDO::PARAM_STR);

        $stmt->execute();

        return $expenseCategoryId = $stmt->fetch();
    }

    /**
     * Extract id of picked payment method
     * 
     * @param string $paymentMethodName subbmited by user
     * 
     * @return int $paymentMethodId method id corresponding with subbmited method name
     */
    private static function getPaymentMethodId($paymentMethodName) {

        $sql = 'SELECT id FROM payment_methods_assigned_to_users 
                WHERE user_id = :loggedUserId AND name = :paymentMethodName';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':paymentMethodName', $paymentMethodName, PDO::PARAM_STR);

        $stmt->execute();

        return $paymentMethodId = $stmt->fetch();
    }

    /**
     * Creating sql statement and add new expense record to database
     * 
     * @param array $newExpenseData expanse data subbmited by user
     * 
     * @return mixed User object if found, false otherwise
     */
    public static function transferNewExpenseData ($newExpenseData) {

        $sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, 
                    amount, date_of_expense, expense_comment)
                VALUES (:user_id, :expense_category_assigned_to_user_id, :payment_method_assigned_to_user_id, 
                    :amount, :date_of_expense, :expense_comment)';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':expense_category_assigned_to_user_id', Expense::getExpenseCategoryId($newExpenseData['expenseCategory']), PDO::PARAM_INT);
        $stmt->bindValue(':payment_method_assigned_to_user_id', Expense::getPaymentMethodId($newExpenseData['expensePaymentMethod']), PDO::PARAM_INT);
        $stmt->bindValue(':amount', $newExpenseData['expenseAmount'], PDO::PARAM_STR);
        $stmt->bindValue(':date_of_expense', $newExpenseData['expanseDate'], PDO::PARAM_STR);
        $stmt->bindValue(':expense_comment', $newExpenseData['expenseComment'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function getLimit($user_id, $category) {

        $expanseCategoryId = Expense::getExpenseCategoryId($category);

        $sql = 'SELECT limit_expense FROM expenses_category_assigned_to_users
                WHERE user_id = :loggedUserId AND id = :expanseCategory';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':expanseCategory', $expanseCategoryId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getMonthlySum($user_id, $category) {
        
        $expanseCategoryId = Expense::getExpenseCategoryId($category);
        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');

        $sql = 'SELECT SUM(expenses.amount) as expenseSumForSelectedCategory 
                FROM expenses 
                WHERE user_id = :loggedUserId AND expense_category_assigned_to_user_id = :expanseCategory 
                AND date_of_expense BETWEEN :dateStart AND :dateEnd';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

        $stmt->bindValue(':loggedUserId', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':expanseCategory', $expanseCategoryId, PDO::PARAM_INT);
        $stmt->bindValue(':dateStart', $dateStart, PDO::PARAM_STR);
        $stmt->bindValue(':dateEnd', $dateEnd, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }
}
