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
     * Show the index page: set for current month
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Balances/index.html', [
            'timePeriod' => "bieżący miesiąc",
            'incomesAmount' => Balance::getIncomesCurrentMonth(),
            'categoryIds' => Balance::getIncomeCategoriesCurrentMonth(),
            'incomesSumCategoriesId' => Balance::getIncomeForCategoryIdCurrentMonth(),
            'expensesAmount' => Balance::getExpensesCurrentMonth(),
            'expenseCategoryIds' => Balance::getExpenseCategoriesCurrentMonth(),
            'expensesSumCategoriesId' => Balance::getExpenseForCategoryIdCurrentMonth(),
            'balance' => Balance::calculateBalanceCurrentMonth()
        ]);
    }

    /**
     * Show incomes and expenses from specific time period: previous month
     * 
     * @return void
     */
    public function previousMonthAction() {

        View::renderTemplate('Balances/index.html', [
            'timePeriod' => "poprzedni miesiąc",
            'incomesAmount' => Balance::getIncomesPreviousMonth(),
            'categoryIds' => Balance::getIncomeCategoriesPreviousMonth(),
            'incomesSumCategoriesId' => Balance::getIncomeForCategoryIdPreviousMonth(),
            'expensesAmount' => Balance::getExpensesPreviousMonth(),
            'expenseCategoryIds' => Balance::getExpenseCategoriesPreviousMonth(),
            'expensesSumCategoriesId' => Balance::getExpenseForCategoryIdPreviousMonth(),
            'balance' => Balance::calculateBalancePreviousMonth()
        ]);
    }

    /**
     * Show incomes and expenses from specific time period: current year
     * 
     * @return void
     */
    public function currentYearAction() {

        View::renderTemplate('Balances/index.html', [
            'timePeriod' => "bieżący rok",
            'incomesAmount' => Balance::getIncomesCurrentYear(),
            'categoryIds' => Balance::getIncomeCategoriesCurrentYear(),
            'incomesSumCategoriesId' => Balance::getIncomeForCategoryIdCurrentYear(),
            'expensesAmount' => Balance::getExpensesCurrentYear(),
            'expenseCategoryIds' => Balance::getExpenseCategoriesCurrentYear(),
            'expensesSumCategoriesId' => Balance::getExpenseForCategoryIdCurrentYear(),
            'balance' => Balance::calculateBalanceCurrentYear()
        ]);
    }
}
