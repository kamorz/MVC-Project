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
		$arrayA = [];
		
        $sql = "SELECT * FROM incomes WHERE user_id = :id AND EXTRACT(month FROM date_of_income) = '$currentMonth'";
		
        $db = static::getDB();
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result['date'] = $row['date_of_income'];
			$result['category'] = $row['income_category_assigned_to_user_id'];
			$result['amount'] = $row['amount'];
			$result['comment'] = $row['income_comment'];		
		}	 
		return $result;
		
		//return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}