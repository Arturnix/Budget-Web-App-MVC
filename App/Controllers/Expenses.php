<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense; 
use \App\Flash;

/**
 * Expenses controller
 *
 * PHP version 7.0
 */
class Expenses extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function showAction()
    {   
        View::renderTemplate('Expenses/show.html', [
            'paymentMethodsDefault' => Expense::getPaymentMethodsAssignedToUser(),
            'expenseCategoriesDefault' => Expense::getExpenseCategoriesAssignedToUser()
        ]);
    }

    /**
     * Transfer submitted data to the database and create new expense record
     * 
     * @return void
     */
    public function createAction() {

        $newExpenseData = [
        'expenseAmount' => $_POST['expenseAmount'],
        'expanseDate' => $_POST['todays-date'],
        'expensePaymentMethod' => $_POST['expensePaymentMethod'],
        'expenseCategory' => $_POST['expenseCategory'],
        'expenseComment' => $_POST['expenseComment']
        ];

        if (Expense::transferNewExpenseData($newExpenseData)) {

            Flash::addMessage('Dodano nowy wydatek');
            $this->redirect('/expenses/show');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/expenses/show');

        }
    }

    public function limitAction() {
        
        $user_id = $_SESSION['user_id'];
        $category = $this->route_params['category'];
       
        echo json_encode(Expense::getLimit($user_id, $category), JSON_UNESCAPED_UNICODE);
    }

    public function monthlySumAction() {

        $user_id = $_SESSION['user_id'];
        $category = $this->route_params['category'];

        echo json_encode(Expense::getMonthlySum($user_id, $category), JSON_UNESCAPED_UNICODE);
    }

}
