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
		
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser($start, $final);
		$arg['incomes']= Overview::findIncomesFromCurrentMonthInDatabase($start, $final);
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;
		
		$expenseCategoriesAssignedToUser= Overview:: findAllExpenseCategoriesAssignedToUser($start, $final);
		$arg['expenses']= Overview::findExpensesFromCurrentMonthInDatabase($start, $final);
		$arg['expenseTypes']= $expenseCategoriesAssignedToUser;		
		
		$totalBalance = $incomeCategoriesAssignedToUser['total'] - $expenseCategoriesAssignedToUser['total'];
		$arg['total_balance']= $totalBalance;

        View::renderTemplate('Overview/CurrentMonth/index.html', $arg);
    }
	
	
	public function previousMonthAction()
    {	
		$start=date('Y-m-d', strtotime(date('Y-m-01').' -1 MONTH'));
		$final=date("Y-m-t", strtotime(' -1 MONTH'));
		$arg['start']= $start;
		$arg['final']=$final;
		
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser($start, $final);
		$arg['incomes']= Overview::findIncomesFromCurrentMonthInDatabase($start, $final);
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;

		$expenseCategoriesAssignedToUser= Overview:: findAllExpenseCategoriesAssignedToUser($start, $final);
		$arg['expenses']= Overview::findExpensesFromCurrentMonthInDatabase($start, $final);
		$arg['expenseTypes']= $expenseCategoriesAssignedToUser;		
		
		$totalBalance = $incomeCategoriesAssignedToUser['total'] - $expenseCategoriesAssignedToUser['total'];
		$arg['total_balance']= $totalBalance;

        View::renderTemplate('Overview/PreviousMonth/index.html', $arg);
    }
	
	
	public function selectedPeriodAction()
    {	
		if (isset( $_POST['beginningDate'] ) && isset( $_POST['endingDate'] ))
		{
		$start = date('Y-m-d', strtotime($_POST['beginningDate']));;
		$final = date('Y-m-d', strtotime($_POST['endingDate']));;
		}
		else
		{
		$start = date("Y-m-d", strtotime('-1 month'));;
		$final = date("Y-m-d", strtotime('today'));
		}
		$arg['start']= $start;
		$arg['final']=$final;
		
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser($start, $final);
		$arg['incomes']= Overview::findIncomesFromCurrentMonthInDatabase($start, $final);
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;

		$expenseCategoriesAssignedToUser= Overview:: findAllExpenseCategoriesAssignedToUser($start, $final);
		$arg['expenses']= Overview::findExpensesFromCurrentMonthInDatabase($start, $final);
		$arg['expenseTypes']= $expenseCategoriesAssignedToUser;		
		
		$totalBalance = $incomeCategoriesAssignedToUser['total'] - $expenseCategoriesAssignedToUser['total'];
		$arg['total_balance']= $totalBalance;

        View::renderTemplate('Overview/SelectedPeriod/index.html', $arg);
    }
}
