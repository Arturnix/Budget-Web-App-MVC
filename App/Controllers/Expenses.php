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
    public function indexAction()
    {   
        View::renderTemplate('Expenses/index.html', [
            'paymentMethodsDefault' => Expense::getPaymentMethodsDefault(),
            'expenseCategoriesDefault' => Expense::getExpenseCategoriesDefault()
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
            $this->redirect('/expenses/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/expenses/index');

        }
    }
}
