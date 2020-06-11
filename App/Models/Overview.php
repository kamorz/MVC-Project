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
		$currentMonth = date("m");
		$result = [];
		$result_full = [];
		$i=0;
		
        $sql = "SELECT * FROM incomes WHERE user_id = :id AND EXTRACT(month FROM date_of_income) = '$currentMonth' ORDER BY date_of_income DESC";
		
        $db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			//$new = array_push($result, $row['date_of_income'], $row['income_category_assigned_to_user_id'], $row['amount'], $row['income_comment']);
			$result['date'] = $row['date_of_income'];
			$result['category'] = static::findIncomeCategoryName($row['income_category_assigned_to_user_id']);
			$result['amount'] = $row['amount'];
			$result['comment'] = $row['income_comment'];	
			$result_full[$i] = $result;
			$i++;
		}	 
		return $result_full;
		
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
}