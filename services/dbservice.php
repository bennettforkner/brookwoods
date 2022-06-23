<?php

namespace Brookwoods
{

	class DBService
	{
		public $mysqli;

		public function __construct($servername, $username, $password, $database)
		{
			$this->mysqli = new \mysqli($servername, $username, $password, $database);
		}
	}

}
