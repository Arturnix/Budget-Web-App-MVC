<?php

namespace App\Models;

use PDO;
use \Core\View;
use \App\Models\User;

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

        $sql = 'SELECT id, name, limit_expense
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

    public static function isNewIncomeNameAvailable($newIncomeName) {

        $sql = 'SELECT name FROM incomes_category_assigned_to_users
                WHERE user_id = :loggedUserId
                AND name = :newName';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newName', $newIncomeName, PDO::PARAM_STR);
        
        $stmt->execute();

        return $stmt->fetchAll();
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

    public static function isNewExpenseNameAvailable($newExpenseName) {

        $sql = 'SELECT name FROM expenses_category_assigned_to_users
                WHERE user_id = :loggedUserId
                AND name = :newName';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newName', $newExpenseName, PDO::PARAM_STR);
        
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function editExpanseName($newExpanseName) {

        $sql = 'UPDATE expenses_category_assigned_to_users
                SET name = :newName
                WHERE id = :oldName
                AND user_id = :loggedUserId';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':newName', $newExpanseName['newName'], PDO::PARAM_STR);
        $stmt->bindValue(':oldName', $newExpanseName['oldName'], PDO::PARAM_INT);
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function isNewPaymentMethodNameAvailable($newPaymentName) {

        $sql = 'SELECT name FROM payment_methods_assigned_to_users
                WHERE user_id = :loggedUserId
                AND name = :newName';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newName', $newPaymentName, PDO::PARAM_STR);
        
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function editPaymentMethodName($newPaymentName) {

        $sql = 'UPDATE payment_methods_assigned_to_users
                SET name = :newName
                WHERE id = :oldName
                AND user_id = :loggedUserId';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':newName', $newPaymentName['newName'], PDO::PARAM_STR);
        $stmt->bindValue(':oldName', $newPaymentName['oldName'], PDO::PARAM_INT);
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function addNewIncomeCategory($newIncomeName) {

        $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name)
                VALUES (:user_id, :newIncomeCategory)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newIncomeCategory', $newIncomeName, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function addNewExpenseCategory($newExpanseName) {

        $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name)
                VALUES (:user_id, :newExpenseCategory)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newExpenseCategory', $newExpanseName, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function addNewPaymentMethod($newPaymentMethod) {

        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                VALUES (:user_id, :newPaymentMethod)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':newPaymentMethod', $newPaymentMethod, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    //delete verification

    public static function usedIncomeCategory() {

        $sql = 'SELECT DISTINCT income_category_assigned_to_user_id FROM incomes
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function usedExpenseCategory() {

        $sql = 'SELECT DISTINCT expense_category_assigned_to_user_id FROM expenses
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function usedPaymentMethod() {

        $sql = 'SELECT DISTINCT payment_method_assigned_to_user_id FROM expenses
                WHERE user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function deleteIncomeCategory($incomeCategoryToDelete) {

        $sql = 'DELETE FROM incomes_category_assigned_to_users
                WHERE user_id = :user_id AND id = :incomeCategoryToDelete;
                DELETE FROM incomes
                WHERE user_id = :user_id AND income_category_assigned_to_user_id = :incomeCategoryToDelete';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':incomeCategoryToDelete', $incomeCategoryToDelete, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function deleteExpenseCategory($expenseCategoryToDelete) {

        $sql = 'DELETE FROM expenses_category_assigned_to_users
                WHERE user_id = :user_id AND id = :expenseCategoryToDelete;
                DELETE FROM expenses
                WHERE user_id = :user_id AND expense_category_assigned_to_user_id = :expenseCategoryToDelete';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':expenseCategoryToDelete', $expenseCategoryToDelete, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function deletePaymentMethod($paymentMethodToDelete) {

        $sql = 'DELETE FROM payment_methods_assigned_to_users
                WHERE user_id = :user_id AND id = :paymentMethodToDelete';
                
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':paymentMethodToDelete', $paymentMethodToDelete, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function validateEditUserName($newUserName) {

        $errors = '';

        if ($newUserName == '') {
            $errors .= "Imię jest wymagane;\r\n";
        }

        if (strlen($newUserName) < 2) {
            $errors .= "Imię musi składać się przynajmniej z 2 znaków;\r\n";
        }

        if (! preg_match('/.*\d+.*/i', $newUserName) == 0) {
            $errors .= "Imię nie może zawierać cyfry;\r\n";
        }

        return $errors;
    }

    public static function editUserName($newUserName) {

        if (empty(Setting::validateEditUserName($newUserName))) {

            $sql = 'UPDATE users
            SET name = :newName
            WHERE id = :loggedUserId';
    
            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':newName', $newUserName, PDO::PARAM_STR);
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public static function validateEditUserEmail($newUserEmail) {

        $errors = '';

        if (filter_var($newUserEmail, FILTER_VALIDATE_EMAIL) === false) {
            $errors .= "Podaj poprawny adres email;\r\n";
        }
        if (User::emailExists($newUserEmail)) {
            $errors .= "Dla podanego adresu email przypisane jest już inne konto;\r\n";
        }

        return $errors;
    }

    public static function editUserEmail($newUserEmail) {

        $editEmailError = Setting::validateEditUserEmail($newUserEmail);

        if(empty($editEmailError)) {

            $sql = 'UPDATE users
                SET email  = :newEmail
                WHERE id = :loggedUserId';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':newEmail', $newUserEmail, PDO::PARAM_STR);
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
        
        return $stmt->execute();

        } else {

            return false;
        }
    }

    public static function validateEditUserPassword($newUserPassword) {

        $errors = '';

        if (strlen($newUserPassword) < 6 || strlen($newUserPassword) > 20) {
            $errors .= "Hasło musi składać się z 6 do 20 znaków;\r\n";
        }

        if (preg_match('/.*[a-z]+.*/i', $newUserPassword) == 0) {
            $errors .= "Hasło musi zawierać literę;\r\n";
        }

        if (preg_match('/.*\d+.*/i', $newUserPassword) == 0) {
            $errors .= "Hasło musi zawierać cyfrę;\r\n";
        }

        return $errors;
    }

    public static function editUserPassword($newUserPassword) {

        $editPasswordError = Setting::validateEditUserPassword($newUserPassword);

        if(empty($editPasswordError)) {

            $password_hash = password_hash($newUserPassword, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
                    SET password_hash  = :newPassword
                    WHERE id = :loggedUserId';
            
            $db = static::getDB();
            $stmt = $db->prepare($sql);
    
            $stmt->bindValue(':newPassword', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            
            return $stmt->execute();

        } else {

            return false;
        }
    }

    private static function deleteUserDataFromAssignedTables() {

        $sql = 'DELETE e, i, p
                FROM expenses_category_assigned_to_users AS e, 
                    incomes_category_assigned_to_users AS i,
                    payment_methods_assigned_to_users AS p
                WHERE e.user_id = :loggedUserId 
                AND i.user_id = :loggedUserId
                AND p.user_id = :loggedUserId';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
    
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            
            return $stmt->execute();
    }

    private static function deleteUserData() {

        $sql = 'DELETE e, i, r
                FROM expenses as e,
                     incomes as i,
                     remembered_logins as r
                WHERE e.user_id = :loggedUserId
                AND i.user_id = :loggedUserId
                AND r.user_id = :loggedUserId';
                            
            $db = static::getDB();
            $stmt = $db->prepare($sql);
    
            $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
            
            return $stmt->execute();
    }

    private static function deleteUserFromUsersTable() {

        $sql = 'DELETE FROM users
                WHERE id = :loggedUserId';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);

                return $stmt->execute();
    }

    public static function deleteUser() {

        if(static::deleteUserDataFromAssignedTables() && static::deleteUserData() && static::deleteUserFromUsersTable()) {
            return true;
        } else {
            return false;
        }
    }

    public static function setLimit($category, $limit) {

        $sql = 'UPDATE expenses_category_assigned_to_users
                SET limit_expense  = :limitValue
                WHERE id = :category AND user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':limitValue', $limit, PDO::PARAM_STR);
        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
       
        return $stmt->execute();
    }

    public static function deleteLimit($category) {
        $sql = 'UPDATE expenses_category_assigned_to_users
                SET limit_expense  = null
                WHERE id = :category AND user_id = :loggedUserId';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
        $stmt->bindValue(':loggedUserId', $_SESSION['user_id'], PDO::PARAM_INT);
       
        return $stmt->execute();
    }
}
