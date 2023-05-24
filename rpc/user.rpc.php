<?php
$payload = file_get_contents('php://input');
$data = json_decode($payload);
echo "username: ".$data->username.", password: ".$data->password;

//var_dump($_REQUEST);
//var_dump($payload);
die;