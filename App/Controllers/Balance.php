<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Overview;
use \App\Flash;

class Balance extends Authenticated
{
	public function currentMonthAction()
    {
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser();
		$arg['incomes']= Overview::findIncomesFromCurrentMonthInDatabase();
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;
		
		$expenseCategoriesAssignedToUser= Overview:: findAllExpenseCategoriesAssignedToUser();
		$arg['expenses']= Overview::findExpensesFromCurrentMonthInDatabase();
		$arg['expenseTypes']= $expenseCategoriesAssignedToUser;		
		
		$totalBalance = $incomeCategoriesAssignedToUser['total'] - $expenseCategoriesAssignedToUser['total'];
		$arg['total_balance']= $totalBalance;

        View::renderTemplate('Overview/CurrentMonth/index.html', $arg);
    }
}
