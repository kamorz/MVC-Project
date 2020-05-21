<?php

namespace App\Models;

use PDO;
use \App\Token;

class Income extends \Core\Model
{
	public function __construct($data = [])
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		};
	}
}
