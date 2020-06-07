<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;

class AddingExpenses extends Authenticated
{

    public function newAction()
    {
		//$incomeCategoriesList= Income::getIncomeCategoriesFromDatabase();
		//$arg['incomes']= $incomeCategoriesList;
        View::renderTemplate('AddingOperations/Expenses/index.html');
        //View::renderTemplate('AddingOperations/Expenses/index.html', $arg);
    }

    /**
     * Add a new item
     *
     * @return void
     */
	 /*
	 
    public function saveAction()
    {
       $income = new Income($_POST);

        if ($income->add()) {

           //$this->redirect('/addingincomes/success');
		   Flash::addMessage('Pomyślnie dodano przychód do listy operacji!');
           $this->redirect('/');
		   

        } else {

            View::renderTemplate('/', [
                'income' => $income
            ]);

        }
    }
	*/
}

