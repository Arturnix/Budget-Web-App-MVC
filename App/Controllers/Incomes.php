<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income; 
use \App\Flash;

/**
 * Expenses controller
 *
 * PHP version 7.0
 */
class Incomes extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {   
        View::renderTemplate('Incomes/index.html', [
            'incomeCategoriesDefault' => Income::getIncomeCategoriesDefault()
        ]);
    }

    /**
     * Transfer submitted data to the database and create new income record
     * 
     * @return void
     */
    public function createAction() {

        $newIncomeData = [
        'incomeAmount' => $_POST['incomeAmount'],
        'incomeDate' => $_POST['todays-date'],
        'incomeCategory' => $_POST['incomeCategory'],
        'incomeComment' => $_POST['incomeComment']
        ];

        if (Income::transferNewIncomeData($newIncomeData)) {

            Flash::addMessage('Dodano nowy przychód');
            $this->redirect('/incomes/index');
            var_dump($newIncomeData);

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/incomes/index');

        }
    }
}
