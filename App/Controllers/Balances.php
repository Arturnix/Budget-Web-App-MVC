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
     * Show the index page: balance set for current month
     *
     * @return void
     */
    public function showAction()
    {
        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');

        View::renderTemplate('Balances/show.html', [
            'timePeriod' => "bieżący miesiąc",
            'incomesData' => Balance::getIncomesData($dateStart, $dateEnd),
            'incomeNamesAndSum' => Balance::getIncomeNamesAndSum($dateStart, $dateEnd),
            'expensesData' => Balance::getExpensesData($dateStart, $dateEnd),
            'expenseNamesAndSum' => Balance::getExpenseNamesAndSum($dateStart, $dateEnd),
            'balance' => Balance::calculateBalance($dateStart, $dateEnd)
        ]);
    }

    /**
     * Show incomes and expenses from specific time period: previous month
     * 
     * @return void
     */
    public function showPreviousMonthAction() {

        $dateStart = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $dateEnd = date('Y-m-t', strtotime(date('Y-m')." -1 month"));

        View::renderTemplate('Balances/show.html', [
            'timePeriod' => "poprzedni miesiąc",
            'incomesData' => Balance::getIncomesData($dateStart, $dateEnd),
            'incomeNamesAndSum' => Balance::getIncomeNamesAndSum($dateStart, $dateEnd),
            'expensesData' => Balance::getExpensesData($dateStart, $dateEnd),
            'expenseNamesAndSum' => Balance::getExpenseNamesAndSum($dateStart, $dateEnd),
            'balance' => Balance::calculateBalance($dateStart, $dateEnd)
        ]);
    }

    /**
     * Show incomes and expenses from specific time period: current year
     * 
     * @return void
     */
    public function showCurrentYearAction() {

        $dateStart = date('Y-m-d', strtotime('first day of january this year'));
        $dateEnd = date('Y-m-d', strtotime('last day of december this year'));

        View::renderTemplate('Balances/show.html', [
            'timePeriod' => "bieżący rok",
            'incomesData' => Balance::getIncomesData($dateStart, $dateEnd),
            'incomeNamesAndSum' => Balance::getIncomeNamesAndSum($dateStart, $dateEnd),
            'expensesData' => Balance::getExpensesData($dateStart, $dateEnd),
            'expenseNamesAndSum' => Balance::getExpenseNamesAndSum($dateStart, $dateEnd),
            'balance' => Balance::calculateBalance($dateStart, $dateEnd)
        ]);
    }

    /**
     * Show incomes and expenses from specific time period: user defined range
     * 
     * @return void
     */
    public function showRangeAction() {

        $dateStart = $_POST['balanceDateStart'];
        $dateEnd = $_POST['balanceDateEnd'];

        if ($dateStart > $dateEnd) {
            $dateStart = $_POST['balanceDateEnd'];
            $dateEnd = $_POST['balanceDateStart'];
        }

        View::renderTemplate('Balances/show.html', [
            'timePeriod' => "zakres wybrany przez użytkonika",
            'incomesData' => Balance::getIncomesData($dateStart, $dateEnd),
            'incomeNamesAndSum' => Balance::getIncomeNamesAndSum($dateStart, $dateEnd),
            'expensesData' => Balance::getExpensesData($dateStart, $dateEnd),
            'expenseNamesAndSum' => Balance::getExpenseNamesAndSum($dateStart, $dateEnd),
            'balance' => Balance::calculateBalance($dateStart, $dateEnd)
        ]);
    }
}
