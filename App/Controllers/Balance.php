<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Overview;
use \App\Flash;

class Balance extends Authenticated
{
	public function currentMonthAction()
    {
		$currentMonthIncomes= Overview:: findIncomesFromCurrentMonthInDatabase();
		$incomeCategoriesAssignedToUser= Overview:: findAllIncomeCategoriesAssignedToUser();
		$arg['incomes']= $currentMonthIncomes;
		$arg['incomeTypes']= $incomeCategoriesAssignedToUser;

        View::renderTemplate('Overview/CurrentMonth/index.html', $arg);
    }
}
