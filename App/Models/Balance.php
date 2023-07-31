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
    public static function getIncomesCurrentMonth() {

        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');

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

    public static function getIncomesPreviousMonth() {

        $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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

    public static function getIncomesCurrentYear() {

        $dateStart = date('Y-m-d', strtotime('first day of january this year'));
        $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

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
        public static function getIncomeCategoriesCurrentMonth() {

            $dateStart = date('Y-m-01');
            $dateEnd = date('Y-m-t');

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

        public static function getIncomeCategoriesPreviousMonth() {

            $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
            $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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

        public static function getIncomeCategoriesCurrentYear() {

            $dateStart = date('Y-m-d', strtotime('first day of january this year'));
            $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

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

        public static function getIncomeForCategoryIdCurrentMonth() {

            $dateStart = date('Y-m-01');
            $dateEnd = date('Y-m-t');

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

        public static function getIncomeForCategoryIdPreviousMonth() {

            $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
            $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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

        public static function getIncomeForCategoryIdCurrentYear() {

            $dateStart = date('Y-m-d', strtotime('first day of january this year'));
            $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

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
    public static function getExpensesCurrentMonth() {

        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');

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

    public static function getExpensesPreviousMonth() {

        $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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

    public static function getExpensesCurrentYear() {

        $dateStart = date('Y-m-d', strtotime('first day of january this year'));
        $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

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
    public static function getExpenseCategoriesCurrentMonth() {

        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');

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

    public static function getExpenseCategoriesPreviousMonth() {

        $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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

    public static function getExpenseCategoriesCurrentYear() {

        $dateStart = date('Y-m-d', strtotime('first day of january this year'));
        $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

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

        public static function getExpenseForCategoryIdCurrentMonth() {

            $dateStart = date('Y-m-01');
            $dateEnd = date('Y-m-t');

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

        public static function getExpenseForCategoryIdPreviousMonth() {

            $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
            $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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

            public static function getExpenseForCategoryIdCurrentYear() {

                $dateStart = date('Y-m-d', strtotime('first day of january this year'));
                $dateEnd = date('Y-m-d', strtotime('last day of december this year'));
    
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

        public static function calculateBalanceCurrentMonth() {

            $dateStart = date('Y-m-01');
            $dateEnd = date('Y-m-t');

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
            var_dump($expensesSum);

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
            var_dump($incomesSum);
           
            $balance = $incomesSum - $expensesSum;

            return $balance;
        }

        public static function calculateBalancePreviousMonth() {

            $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
            $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

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
            var_dump($expensesSum);

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
            var_dump($incomesSum);
           
            $balance = $incomesSum - $expensesSum;

            return $balance;
        }

        public static function calculateBalanceCurrentYear() {

            $dateStart = date('Y-m-d', strtotime('first day of january this year'));
            $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

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
            var_dump($expensesSum);

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
            var_dump($incomesSum);
           
            $balance = $incomesSum - $expensesSum;

            return $balance;
        }

}
