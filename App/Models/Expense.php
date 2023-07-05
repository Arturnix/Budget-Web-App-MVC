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
     * Get payment methods from database
     * 
     * @return array
     */
    public static function getPaymentMethodsDefault () {

        $sql = 'SELECT * FROM payment_methods_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 1);

        $stmt->execute();

        return $paymentMethodsDefault = $stmt->fetchAll();
    }

    /**
     * Get expenses categories from database
     * 
     * @return array
     */
    public static function getExpenseCategoriesDefault () {
        
        $sql = 'SELECT * FROM expenses_category_default ORDER BY id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 1);

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
    private static function getExpenseCategoryId ($expenseCategoryName) {

        $sql = 'SELECT id FROM expenses_category_default 
                WHERE name = :expenseCategoryName';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

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
    private static function getPaymentMethodId ($paymentMethodName) {

        $sql = 'SELECT id FROM payment_methods_default 
                WHERE name = :paymentMethodName';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);

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
}
