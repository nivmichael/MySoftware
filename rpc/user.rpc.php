<?php

require_once '../autoload.php';

$username   = $_REQUEST['username'];
$password   = $_REQUEST['password'];

var_dump($_REQUEST);
var_dump(json_decode(array_keys($_REQUEST)[0])->username );
var_dump(json_decode(array_keys($_REQUEST)[0])->password );

die;

