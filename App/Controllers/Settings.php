<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Setting;
use \App\Flash;
use \App\Auth;

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
    public function showAction()
    {
        View::renderTemplate('Settings/show.html', [
            'incomesCategories' => Setting::getIncomeName(),
            'expensesCategories' => Setting::getExpenseName(),
            'paymentMethods' => Setting::getPaymentMethods(),
            'incomeCategoryUsed' => Setting::usedIncomeCategory(),
            'expenseCategoryUsed' => Setting::usedExpenseCategory(),
            'paymentMethodUsed' => Setting::usedPaymentMethod()
        ]);   
    }

    public function editIncomeNameAction() {

        $newIncomeName = [
            'newName' => $_POST['newIncomeName'],
            'oldName' => $_POST['editIncomeName']
        ];

       if (empty(Setting::isNewIncomeNameAvailable($newIncomeName['newName']))) {

            if (Setting::editIncomeName($newIncomeName)) {

                Flash::addMessage('Zamieniono nazwę przychodu');
                $this->redirect('/settings/show');

            } else {

                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');

            }

        } else {

            Flash::addMessage("Podana nazwa jest już zajeta. Podaj inną nazwę.", Flash::WARNING);
            $this->redirect('/settings/show');
        }
    }

    public function editExpenseNameAction() {

        $newExpenseName = [
            'newName' => $_POST['newExpenseName'],
            'oldName' => $_POST['editExpanseName']
        ];

        if (empty(Setting::isNewExpenseNameAvailable($newExpenseName['newName']))) {

            if (Setting::editExpanseName($newExpenseName)) {

                Flash::addMessage('Zamieniono nazwę wydatku');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }

        } else {

            Flash::addMessage("Podana nazwa jest już zajeta. Podaj inną nazwę.", Flash::WARNING);
            $this->redirect('/settings/show');

        }
    }

    public function editPaymentMethodNameAction() {

        $newPaymentName = [
            'newName' => $_POST['newPaymentName'],
            'oldName' => $_POST['editPaymentMethod']
        ];

        if (empty(Setting::isNewPaymentMethodNameAvailable($newPaymentName['newName']))) {

            if (Setting::editPaymentMethodName($newPaymentName)) {

                Flash::addMessage('Zamieniono nazwę sposobu płatności');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }
        } else {

            Flash::addMessage("Podana nazwa jest już zajeta. Podaj inną nazwę.", Flash::WARNING);
            $this->redirect('/settings/show');
        }
    }

    public function addNewIncomeCategoryAction() {

        $newIncomeName = $_POST['newIncomeName'];

        if (empty(Setting::isNewIncomeNameAvailable($newIncomeName))) {

            if (Setting::addNewIncomeCategory($newIncomeName)) {

                Flash::addMessage('Dodano nową kategorię przychodu');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }
        } else {

            Flash::addMessage("Podana nazwa jest już zajeta. Podaj inną nazwę.", Flash::WARNING);
            $this->redirect('/settings/show');
        }
    }

    public function addNewExpenseCategoryAction() {

        $newExpenseName = $_POST['newExpenseName'];

        if (empty(Setting::isNewExpenseNameAvailable($newExpenseName))) {

            if (Setting::addNewExpenseCategory($newExpenseName)) {

                Flash::addMessage('Dodano nową kategorię wydatku');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }
        } else {

            Flash::addMessage("Podana nazwa jest już zajeta. Podaj inną nazwę.", Flash::WARNING);
            $this->redirect('/settings/show');
        }
           
        
    }

    public function addNewPaymentMethodAction() {

        $newPaymentMethod = $_POST['newPaymentMethod'];

        if (empty(Setting::isNewPaymentMethodNameAvailable($newPaymentMethod))) {

            if (Setting::addNewPaymentMethod($newPaymentMethod)) {

                Flash::addMessage('Dodano nową metodę płatności');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }
        } else {

            Flash::addMessage("Podana nazwa jest już zajeta. Podaj inną nazwę.", Flash::WARNING);
            $this->redirect('/settings/show');
        }
    }

    //delete category

    public function usedIncomeCategory() {

        var_dump(Setting::usedIncomeCategory());
    }

    

    public function deleteIncomeCategoryAction() {

        $incomeCategoryToDelete = $_POST['incomeCategoryToDelete'];

        if (Setting::deleteIncomeCategory($incomeCategoryToDelete)) {

            Flash::addMessage('Usunięto kategorię przychodu');
            $this->redirect('/settings/show');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/show');

        }
    }

    public function deleteExpenseCategoryAction() {

        $expenseCategoryToDelete = $_POST['deleteExpanseCategory'];
           
        if (Setting::deleteExpenseCategory($expenseCategoryToDelete)) {

            Flash::addMessage('Usunięto kategorię wydatku');
            $this->redirect('/settings/show');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/show');

        }
    }

    public function deletePaymentMethodAction() {

        $paymentMethodToDelete = $_POST['deletePaymentMethod'];
           
        if (Setting::deletePaymentMethod($paymentMethodToDelete)) {

            Flash::addMessage('Usunięto metodę płatności');
            $this->redirect('/settings/show');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/show');

        }
    }

    public function editUserNameAction() {

        $newUserName = $_POST['newUserName'];

        if (empty(Setting::validateEditUserName($newUserName))) {

            if (Setting::editUserName($newUserName)) {

                Flash::addMessage('Zamieniono imię użytkownika');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }
        } else {

            Flash::addMessage(Setting::validateEditUserName($newUserName), Flash::WARNING);
            $this->redirect('/settings/show');
        }
    }

    public function editUserEmailAction() {

        $newUserEmail = $_POST['newUserEmail'];

        if(empty(Setting::validateEditUserEmail($newUserEmail))) {

            if (Setting::editUserEmail($newUserEmail)) {

                Flash::addMessage('Zamieniono email użytkownika');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }

        } else {

            Flash::addMessage(Setting::validateEditUserEmail($newUserEmail), Flash::WARNING);
            $this->redirect('/settings/show');
        } 
    }

    public function editUserPasswordAction() {

        $newUserPassword = $_POST['newUserPassword'];

        if(empty(Setting::validateEditUserPassword($newUserPassword))) {

            if (Setting::editUserPassword($newUserPassword)) {

                Flash::addMessage('Zamieniono hasło użytkownika');
                $this->redirect('/settings/show');
    
            } else {
    
                Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
                $this->redirect('/settings/show');
    
            }

        } else {

            Flash::addMessage(Setting::validateEditUserPassword($newUserPassword), Flash::WARNING);
            $this->redirect('/settings/show');
        }
    }

    public function deleteUserAction() {

        if (Setting::deleteUser()) {

            Auth::logout();
            $this->redirect('/login/show-delete-user-message');

        } else {

            Flash::addMessage('Operacja nie powiodła się. Spróbuj ponownie.', Flash::WARNING);
            $this->redirect('/settings/show');

        }
    }
}
