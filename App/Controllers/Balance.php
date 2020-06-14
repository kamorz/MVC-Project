<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Overview;
use \App\Flash;

class Balance extends Authenticated
{
	public function currentMonthAction()
    {
		$start = date('Y-m-d', strtotime(date('Y-m-01')));
		$final = date("Y-m-t", strtotime('today'));
		$arg['start']= $start;
		$arg['final']=$final;
		
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser('0');
		$arg['incomes']= Overview::findIncomesFromCurrentMonthInDatabase('0');
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;
		
		$expenseCategoriesAssignedToUser= Overview:: findAllExpenseCategoriesAssignedToUser('0');
		$arg['expenses']= Overview::findExpensesFromCurrentMonthInDatabase('0');
		$arg['expenseTypes']= $expenseCategoriesAssignedToUser;		
		
		$totalBalance = $incomeCategoriesAssignedToUser['total'] - $expenseCategoriesAssignedToUser['total'];
		$arg['total_balance']= $totalBalance;

        View::renderTemplate('Overview/CurrentMonth/index.html', $arg);
    }
	
	public function previousMonthAction()
    {	
		$arg['start']=date('Y-m-d', strtotime(date('Y-m-01').' -1 MONTH'));
		$arg['final']=date("Y-m-t", strtotime(' -1 MONTH'));
		
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser('1');
		$arg['incomes']= Overview::findIncomesFromCurrentMonthInDatabase('1');
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;

		$expenseCategoriesAssignedToUser= Overview:: findAllExpenseCategoriesAssignedToUser('1');
		$arg['expenses']= Overview::findExpensesFromCurrentMonthInDatabase('1');
		$arg['expenseTypes']= $expenseCategoriesAssignedToUser;		
		
		$totalBalance = $incomeCategoriesAssignedToUser['total'] - $expenseCategoriesAssignedToUser['total'];
		$arg['total_balance']= $totalBalance;

        View::renderTemplate('Overview/PreviousMonth/index.html', $arg);
    }
}
