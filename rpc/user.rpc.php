<?php
$payload = file_get_contents('php://input');
$data = json_decode($payload);
echo "username: ".$data->username.", password: ".$data->password;

/*
1. Add a $action variable that stores the $_GET param 'action'
2. Create a switch/case bloke that uses action as it's switch
3. In the 'userLogin' case - validate that we got both the username and password
4. If missing one of them, return JSON error to client and print beneath the login form
5. If both params are OK, call a method in user.class.php named login_user that gets both params
6. Create the users table in MySQL - talk with michael about changes.sql + schema.sql
*/

//var_dump($_REQUEST);
//var_dump($payload);
die;