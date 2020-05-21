<?php

namespace App\Controllers;

use \Core\View;

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
        echo "dodano";
    }

    public function showAction()
    {
        echo "pokazano";
    }
}
