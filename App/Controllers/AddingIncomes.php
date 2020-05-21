<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;

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

            $this->redirect('/');

        } else {

            View::renderTemplate('/', [
                'income' => $income
            ]);

        }
    }

    public function showAction()
    {
        echo "pokazano";
    }
}

 /*$income = new Income($_POST);

        if ($income->add()) {

            $this->redirect('/');

        } else {

            View::renderTemplate('/newIncome', [
                'income' => $income
            ]);

        }
	*/