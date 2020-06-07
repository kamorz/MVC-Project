<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

class AddingExpenses extends Authenticated
{

    public function newAction()
    {
		$incomeCategoriesList= Expense::getExpenseCategoriesFromDatabase();
		$paymentMethodsList= Expense::getPaymentMethodsFromDatabase();
		$arg['expenses']= $incomeCategoriesList;
		$arg['paymentMethods']= $paymentMethodsList;
        //View::renderTemplate('AddingOperations/Expenses/index.html');
        View::renderTemplate('AddingOperations/Expenses/index.html', $arg);
    }

    /**
     * Add a new item
     *
     * @return void
     */
	 
	 
    public function saveAction()
    {
       $income = new Expense($_POST);

        if ($income->add()) {

           //$this->redirect('/addingincomes/success');
		   Flash::addMessage('Pomyślnie dodano wydatek do listy operacji!');
           $this->redirect('/');
		   

        } else {

            View::renderTemplate('/', [
                'expense' => $expense
            ]);

        }
    }
	
}

