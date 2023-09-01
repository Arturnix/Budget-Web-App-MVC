<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Setting;
use \App\Flash;

/**
 * Settings controller
 *
 * PHP version 7.0
 */
class Settings extends \Core\Controller
{

    /**
     * Show the index page: settings. Edit, add, remove categories. Change user properties, delete user.
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Settings/index.html', [
            'incomesCategories' => Setting::getIncomeName(),
            'expensesCategories' => Setting::getExpenseName(),
            'paymentMethods' => Setting::getPaymentMethods()
        ]);     
    }

    public function editIncomeNameAction() {

        $newIncomeName = [
            'newName' => $_POST['newIncomeName'],
            'oldName' => $_POST['editIncomeName']
        ];

        if (Setting::editIncomeName($newIncomeName)) {

            Flash::addMessage('Zamieniono nazwę przychodu');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function editExpenseNameAction() {

        

        $newExpanseName = [
            'newName' => $_POST['newExpenseName'],
            'oldName' => $_POST['editExpanseName']
        ];

        if (Setting::editExpanseName($newExpanseName)) {

            Flash::addMessage('Zamieniono nazwę wydatku');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }
}
