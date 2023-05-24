<?php
$payload = file_get_contents('php://input');
var_dump($_REQUEST);
var_dump($payload);
die;