<?php

// Read the variables sent via POST from our API
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
$level = explode(“*”, $text);


// // database name
// $servername = "localhost";
// $username = "id19949420_ussd";
// $password = "PDAFk0?T9+Szhr";

// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


if ($text == "") {
    // This is the first request. Note how we start the response with CON
    $response  = "CON WELCOME SHULE POA \n";
    $response .= "1. Registration \n";
    $response .= "2. Primary \n";
    $response .= "3. Secondary \n";
    $response .= "4. College \n";

}


if($level[0]=='1'){
           if(isset($level[0]) && $level[0]!=”” && !isset($level[1])){
        
                $response="Enter Full name";
            
            }else if(isset($level[1]) && $level[1]!=”” && !isset($level[2])){
                
                $response="CON Hi".$level[1].",enter your age\n";
                
            } else if(isset($level[2]) && $level[2]!=”” && !isset($level[3])){
                
                $data=array(
                'phonenumber'=>$phoneNumber,
                'fullname' =>$level[1],
                'age' => $level[2],
                );
                
                $response="END Thank you ".$level[1]." for registering.\nWe will keep you updated";
                // Echo the response back to the API
                header('Content-type: text/plain');
                echo $response;
            }
}