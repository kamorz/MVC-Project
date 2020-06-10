<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

class Balance extends Authenticated
{
	public function currentMonthAction()
    {
		//$incomeCategoriesList= Expense::getExpenseCategoriesFromDatabase();
		//$paymentMethodsList= Expense::getPaymentMethodsFromDatabase();
		//$arg['expenses']= $incomeCategoriesList;
		//$arg['paymentMethods']= $paymentMethodsList;
        //View::renderTemplate('AddingOperations/Expenses/index.html');
        View::renderTemplate('Overview/CurrentMonth/index.html');
        //View::renderTemplate('Overview/CurrentMonth/index.html', $arg);
    }
}
