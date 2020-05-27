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
			
            $sql = 'INSERT INTO incomes (user_id, amount, date_of_income, income_comment)
            VALUES (:user_id, :cash, :date, :addDesc)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':cash', $this->cash, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':addDesc', $this->addDesc, PDO::PARAM_STR);

            return $stmt->execute();
    }
}

/*	public function add()
    {
            $sql = 'INSERT INTO incomes (id, user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment)
            VALUES (NULL, "1", "1", :cash, :date, :addDesc)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':cash', $this->cash, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':addDesc', $this->addDesc, PDO::PARAM_STR);

            return $stmt->execute();
    }
	*/