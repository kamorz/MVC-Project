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
		$arg['incomes']= $currentMonthIncomes;

        View::renderTemplate('Overview/CurrentMonth/index.html', $arg);
    }
}
