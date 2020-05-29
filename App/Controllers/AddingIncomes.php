<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;

class AddingIncomes extends Authenticated
{

    public function newAction()
    {
        View::renderTemplate('AddingOperations/Incomes/index.html');
    }

    /**
     * Add a new item
     *
     * @return void
     */
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
	
}

