<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Models\User;

class Overview extends \Core\Model
{
	public static function findIncomesFromCurrentMonthInDatabase()
    {
		$id = ($_SESSION['user_id']);
		$currentMonth = static::findSuitableMonth();
		$counter=0;
		$result_full = array();
		
        $sql = "SELECT * FROM incomes WHERE user_id = :id AND EXTRACT(month FROM date_of_income) = '$currentMonth' ORDER BY date_of_income DESC";
		
        $db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result['date'] = $row['date_of_income'];
			$result['category'] = static::findIncomeCategoryName($row['income_category_assigned_to_user_id']);
			$result['amount'] = $row['amount'];
			$result['comment'] = $row['income_comment'];	
			$result_full[$counter] = $result;
			$counter++;
		}	 
		if ($result_full>0)
		{
		return $result_full;
		}		
		else return 0;
		
    }
	
	public static function findExpensesFromCurrentMonthInDatabase()
    {
		$id = ($_SESSION['user_id']);
		$currentMonth = static::findSuitableMonth();
		$counter=0;
		$result_full = array();
		
        $sql = "SELECT * FROM expenses WHERE user_id = :id AND EXTRACT(month FROM date_of_expense) = '$currentMonth' ORDER BY date_of_expense DESC";
		
        $db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result['date'] = $row['date_of_expense'];
			$result['category'] = static::findExpenseCategoryName($row['expense_category_assigned_to_user_id']);
			$result['method'] = static::findExpensePaymentMethod($row['payment_method_assigned_to_user_id']);
			$result['amount'] = $row['amount'];
			$result['comment'] = $row['expense_comment'];	
			$result_full[$counter] = $result;
			$counter++;
		}	 
		if ($result_full>0)
		{
		return $result_full;
		}		
		else return 0;
		
    }
	
	public static function findIncomeCategoryName($id)
    {
        $sql = 'SELECT name FROM incomes_category_assigned_to_users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['name'];

    }
	
	
	public static function findExpenseCategoryName($id)
    {
        $sql = 'SELECT name FROM expenses_category_assigned_to_users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['name'];

    }
	
	public static function findExpensePaymentMethod($id)
    {
        $sql = 'SELECT name FROM payment_methods_assigned_to_users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['name'];

    }
	
	public static function findAllIncomeCategoriesAssignedToUser()
	{
		$user_id = ($_SESSION['user_id']);
		$counter=0;
		$sum=0;
		
		$sql = 'SELECT name FROM incomes_category_assigned_to_users WHERE user_id = :user_id';
		
		$db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result['name'] = $row['name'];
			$result['sum'] =  static::findSumOfIncomeCategory($row['name'], $user_id);
			$sum += $result['sum'];
			$result_full[$counter] = $result;
			$counter++;
		}		
		$result_full['total']=$sum;
		return $result_full;
	}
	
	public static function findAllExpenseCategoriesAssignedToUser()
	{
		$user_id = ($_SESSION['user_id']);
		$counter=0;
		$sum=0;
		
		$sql = 'SELECT name FROM expenses_category_assigned_to_users WHERE user_id = :user_id';
		
		$db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result['name'] = $row['name'];
			$result['sum'] =  static::findSumOfExpenseCategory($row['name'], $user_id);
			$sum += $result['sum'];
			$result_full[$counter] = $result;
			$counter++;
		}		
		$result_full['total']=$sum;
		return $result_full;
	}
	
	public static function findSumOfIncomeCategory($name, $user_id)
    {
		$category_id = static::findIncomeCategoryID($name, $user_id);
		$currentMonth = static::findSuitableMonth();
		$sum = 0;
		
        $sql = "SELECT amount FROM incomes WHERE income_category_assigned_to_user_id = :category_id AND user_id = :user_id AND EXTRACT(month FROM date_of_income) = '$currentMonth' ORDER BY date_of_income DESC";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$sum += $row['amount'];
		}
		return $sum;

    }
	
	public static function findSumOfExpenseCategory($name, $user_id)
    {
		$category_id = static::findExpenseCategoryID($name, $user_id);
		$currentMonth = static::findSuitableMonth();
		$sum = 0;
		
        $sql = "SELECT amount FROM expenses WHERE expense_category_assigned_to_user_id = :category_id AND user_id = :user_id AND EXTRACT(month FROM date_of_expense) = '$currentMonth' ORDER BY date_of_expense DESC";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$sum += $row['amount'];
		}
		return $sum;

    }
	
	public static function findIncomeCategoryID($name, $user_id)
    {
        $sql = 'SELECT id FROM incomes_category_assigned_to_users WHERE name = :name AND  user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['id'];

    }
	
	public static function findExpenseCategoryID($name, $user_id)
    {
        $sql = 'SELECT id FROM expenses_category_assigned_to_users WHERE name = :name AND  user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['id'];

    }
	
	public static function findSuitableMonth()
	{
		$currentMonth = date("m");
		return $currentMonth;
	}
}