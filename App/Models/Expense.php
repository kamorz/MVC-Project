<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Models\User;

class Expense extends \Core\Model
{
	public function __construct($data = [])
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		};
	}
	
	public function add()
    {
			$user_id = $_SESSION['user_id'];
			$category_id = static::findCategoryID($user_id, $this->category);
			$payment_method_id = static::findPaymentMethodID($user_id, $this->paymentMethod);
			
			//$message = $category_id;
			//echo "<script type='text/javascript'>alert('$message');</script>";
			
            $sql = 'INSERT INTO expenses (user_id, amount, date_of_expense, expense_comment, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id)
            VALUES (:user_id, :cash, :date, :addDesc, :category_id, :payment_method_id)';  
			
            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':cash', $this->cash, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':addDesc', $this->addDesc, PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT); 
            $stmt->bindValue(':payment_method_id', $payment_method_id, PDO::PARAM_INT); 

            return $stmt->execute();
    }
	
	
	 public static function findCategoryID($user_id, $category)
    {
        $sql = 'SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :category ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['id'];

    }
	
	public static function findPaymentMethodID($user_id, $method)
    {
        $sql = 'SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :method ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':method', $method, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['id'];

    }

	
	public static function getExpenseCategoriesFromDatabase()
    {
		$id = ($_SESSION['user_id']);
        $sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE user_id = :id';
		
		$result = array();
        $db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result[] = $row['name'];
		}		
		return $result;
    }

	public static function getPaymentMethodsFromDatabase()
    {
		$id = ($_SESSION['user_id']);
        $sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE user_id = :id';
		
		$result = array();
        $db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result[] = $row['name'];
		}		
		return $result;
    }
	
}