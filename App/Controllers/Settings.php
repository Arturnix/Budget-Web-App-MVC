<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Setting;

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

        //var_dump($_POST);

        $newIncomeName = [
            'newName' => $_POST['newIncomeName'],
            'oldName' => $_POST['editIncomeName']
        ];
    }
}
