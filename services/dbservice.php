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

		public function getActivities() {
			$sql = "SELECT * FROM brookwoods.Activity";
			$result = $this->mysqli->query($sql);
			$activities = array();
			while ($row = $result->fetch_assoc()) {
				$activities[] = $row;
			}
			return $activities;
		}

		public function getActivityFromSlug($slug) {
			$sql = "SELECT *
			FROM brookwoods.Activity
			WHERE slug = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param("s", $slug);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
	}

}
