<?php

$uri = $_SERVER['REQUEST_URI'];

preg_match('/\/activity\/(.*?)\//', $uri, $activityName);
$activityName = str_replace('/', '', $activityName[1]);

$activity = $_db->getActivityFromSlug($activityName);

?>

<h1 style='text-align: center;'><?=  $activity['name'] ?></h1>