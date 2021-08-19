<?php
// Case we've recieved a json requst
$json_payload = json_decode(file_get_contents('php://input'), true);

if($json_payload) {
    $response_array = ['success' => 'J yes'];
    echo json_encode($response_array);
}

// Case we've recieved a regular post request 
if(isset($_GET['country'])) {
   $response_array = ['success' => 'P yes'];
   var_dump($response_array);
} 

exit;