<?php

// Read the variables sent via POST from our API
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

// $sessionId   = 1;
// $serviceCode = 123;
// $phoneNumber = '0692041839';
// $text        = "";

$level = explode("*", $text);   


// database name
$servername = "localhost";
$username = "id19949420_ussd";
$password = "PDAFk0?T9+Szhr";
$dbname = "id19949420_ussd_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

 $sql = "SELECT * FROM Students WHERE phone = '$phoneNumber'";
 $result = mysqli_query($conn, $sql);  

 
if (isset($text)) {
    if (mysqli_num_rows($result) == 0  && $text == "" ) {
        $response  = "CON WELCOME SHULE POA \n";
        $response .= "1. Registration \n";
             
    }else if(mysqli_num_rows($result) !=0 && $text == "" ){
        $student = $result->fetch_assoc();
        $response  = "CON WELCOME SHULE POA"." ".$student['name']."\n";
        $response .= "Enter Password \n";
    }
if($text != "" ){
    if($level[0]=='1'){
            if(isset($level[0]) && $level[0]!="" && !isset($level[1])){
                            $response = "CON Enter Full name\n";
                    
                }else if(isset($level[1]) && $level[1]!="" && !isset($level[2])){
                    $class = "SELECT id,name FROM Classes";
                    $class_result = mysqli_query($conn, $class);
                    $response="CON Hi ".$level[1].", Choose Class\n";
                    while($row = mysqli_fetch_assoc($class_result)){
                        $response .= $row['id'].". ".$row['name']."\n";
                    }  
                }else if(isset($level[2]) && $level[2]!="" && !isset($level[3])){
                    $response = "CON Year of Study\n";
                }else if(isset($level[3]) && $level[3]!="" && !isset($level[4])){
                    $response = "CON Create Password\n";
                }else if(isset($level[4]) && $level[4]!="" && !isset($level[5])){
                
                    $data=array(
                    'phone'=>$phoneNumber,
                    'name' =>$level[1],
                    'class_id' => $level[2],
                    'year_of_study' => $level[3],
                    'password' => $level[4],
                    );
                    $insert_data = "INSERT INTO Students (phone, name, class_id, year_of_study, password) 
                    VALUES ('".$data['phone']."', '".$data['name']."', '".$data['class_id']."', '".$data['year_of_study']."', '".$data['password']."')";
                    if (mysqli_query($conn, $insert_data)) {
                        $response = "END Registration Successful";
                    } else {
                        $response = "END Registration Failed";
                    }
                         
                }
                
            // Echo the response back to the API
            
    }else if(mysqli_num_rows($result) > 0){
        if(isset($level[0]) && $level[0]!="" && !isset($level[1])){
         //get password from database
         $user_password=$level[0];
         $get_password = "SELECT password,name FROM Students WHERE password = '$user_password'";
         $password_result = $conn->query($get_password);
         $password = $password_result->fetch_assoc();

         //check if password is correct
         if($password['password'] == $user_password){
             $response="CON Welcome ".$password['name']."\n";
             $response .= "1. Examination Results \n";
             $response .= "2. School payments  \n";
             $response .= "3. Teachers telephone numbers \n";
             $response .= "4. Opinions or Claims \n";
         }else{
             $response="END Wrong Password:";
         }
        
       } else if(isset($level[1]) && $level[1]!="" && !isset($level[2])){
        //get student class
            // $get_class = "SELECT 'class.name as class' FROM Students INNER JOIN Classes 
            //         ON Students.class_id = Classes.id WHERE 'phone' = $phoneNumber";
            // $class = $conn->query($get_class);
            
            if($level[1]=='1'){
                //get student results by Class
                // $get_results = "SELECT 'subject.name as subject','marks' FROM Results INNER JOIN Subjects 
                //        ON Results.subject_id = Subjects.id WHERE 'student_id' = $phoneNumber";
                // $results = $conn->query($get_results);
                // end of getting results
                $response="END Your Examination Results are as follows \n";
                $response .= "1. English 70 \n";
                $response .= "2. Kiswahili 60 \n";
                $response .= "3. Mathematics 99 \n";
                $response .= "4. Science 57 \n";
                $response .= "5. Social Studies 49 \n";
                $response .="Thank you for using Shule Poa.\n";
            }else if($level[1]=='2'){
                $response="END Your School Payments are as follows \n";
                $response .= "1. Term 1 200,000 \n";
                $response .= "2. Term 2 400,000 \n";
                $response .= "3. Term 3 200,000 \n";
                $response .="Thank you for using Shule Poa.\n";
            }else if($level[1]=='3'){
                $response="END Your Teachers Telephone Numbers are as follows \n";
                $response .= "1. English 984884 \n";
                $response .= "2. Kiswahili 478288 \n";
                $response .= "3. Mathematics 747999 \n";
                $response .= "4. Science 7492789 \n";
                $response .= "5. Social Studies 729792 \n";
                $response .="Thank you for using Shule Poa.\n";
            }else if($level[1]=='4'){
                $response="END Your Opinions or Claims are as follows \n";
                $response .= "1. English \n";
                $response .= "2. Kiswahili \n";
                $response .= "3. Mathematics \n";
                $response .= "4. Science \n";
                $response .= "5. Social Studies \n";
                $response .="Thank you for using Shule Poa.\n";
            }else{
                $response="END Wrong Input";
            }

            
            
        }
        
    }else{
        $response="END Wrong input choice";
    }
}
 
        header('Content-type: text/plain');
        echo $response;

}
