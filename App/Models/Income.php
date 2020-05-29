<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Models\User;

class Income extends \Core\Model
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
			
			//$message = $category_id;
			//echo "<script type='text/javascript'>alert('$message');</script>";
			
            $sql = 'INSERT INTO incomes (user_id, amount, date_of_income, income_comment, income_category_assigned_to_user_id)
            VALUES (:user_id, :cash, :date, :addDesc, :category_id)';  
			
            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':cash', $this->cash, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':addDesc', $this->addDesc, PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT); 

            return $stmt->execute();
    }
	
	
	 public static function findCategoryID($user_id, $category)
    {
        $sql = 'SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :category ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['id'];

    }
}