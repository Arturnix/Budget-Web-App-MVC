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

    public function editPaymentMethodNameAction() {

        $newPaymentName = [
            'newName' => $_POST['newPaymentName'],
            'oldName' => $_POST['editPaymentMethod']
        ];

        if (Setting::editPaymentMethodName($newPaymentName)) {

            Flash::addMessage('Zamieniono nazwę sposobu płatności');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function addNewIncomeCategoryAction() {

        $newIncomeName = $_POST['newIncomeName'];
           
        if (Setting::addNewIncomeCategory($newIncomeName)) {

            Flash::addMessage('Dodano nową kategorię przychodu');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function addNewExpenseCategoryAction() {

        $newExpanseName = $_POST['newExpenseName'];
           
        if (Setting::addNewExpenseCategory($newExpanseName)) {

            Flash::addMessage('Dodano nową kategorię wydatku');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function addNewPaymentMethodAction() {

        $newPaymentMethod = $_POST['newPaymentMethod'];
           
        if (Setting::addNewPaymentMethod($newPaymentMethod)) {

            Flash::addMessage('Dodano nową metodę płatności');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function deleteIncomeCategoryAction() {

        $incomeCategoryToDelete = $_POST['incomeCategoryToDelete'];
           
        if (Setting::deleteIncomeCategory($incomeCategoryToDelete)) {

            Flash::addMessage('Usunięto kategorię przychodu');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function deleteExpenseCategoryAction() {

        $expenseCategoryToDelete = $_POST['deleteExpanseCategory'];
           
        if (Setting::deleteExpenseCategory($expenseCategoryToDelete)) {

            Flash::addMessage('Usunięto kategorię wydatku');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function deletePaymentMethodAction() {

        $paymentMethodToDelete = $_POST['deletePaymentMethod'];
           
        if (Setting::deletePaymentMethod($paymentMethodToDelete)) {

            Flash::addMessage('Usunięto metodę płatności');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function editUserNameAction() {

        $newUserName = $_POST['newUserName'];

        if (Setting::editUserName($newUserName)) {

            Flash::addMessage('Zamieniono imię użytkownika');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function editUserEmailAction() {

        $newUserEmail = $_POST['newUserEmail'];

        if (Setting::editUserEmail($newUserEmail)) {

            Flash::addMessage('Zamieniono email użytkownika');
            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }

    public function editUserPasswordAction() {

        $newUserPassword = $_POST['newUserPassword'];

        if (Setting::editUserPassword($newUserPassword)) {

            Flash::addMessage('Zamieniono hasło użytkownika');
            $this->redirect('/settings/index');

        } else {

            //Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            Flash::addMessage(Setting::validateEditUserPassword($newUserPassword), Flash::WARNING);
            $this->redirect('/settings/index');

        }
    }
}
