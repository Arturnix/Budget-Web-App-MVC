<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;
use \App\Models\Income;  

/**
 * Balance controller
 *
 * PHP version 7.0
 */
class Balances extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
       /* Balance::getSumIncomesAssignedToCategoryId();*/
       /*var_dump(Balance::getIncomeForCategoryId());*/

       /*var_dump(Balance::getIncomeCategories());*/

       /*var_dump(Balance::getExpenseCategories());*/

       /* View::renderTemplate('Balances/index.html', [
            'incomes' => Balance::getIncomeForCategoryId(1),
            'incomeCategoryNames' => Income::getIncomeCategoriesDefault(),

        ]);*/

        View::renderTemplate('Balances/index.html', [
            'categoryIds' => Balance::getIncomeCategories(),
            'incomesAmount' => Balance::getIncomes(),
            'incomesSumCategoriesId' => Balance::getIncomeForCategoryId(),
            'expensesAmount' => Balance::getExpenses(),
            'expenseCategoryIds' => Balance::getExpenseCategories()
        ]);
    }

    /**
     * Show incomes and expenses from specific time period 
     * 
     * @return void
     */
    public function showAction() {



    }
}
