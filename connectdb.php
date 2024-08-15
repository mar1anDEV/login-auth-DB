<?php  

$hostname = "localhost";
$username = "testroot";
$password = "Nikos445";
$database = "registration";

$conn = mysqli_connect($hostname,$username,$password,$database);
    // Check connection
    if (!$conn) {
        // Connection failed
        echo "Connection failed: " . mysqli_connect_error();
    } else {
        // Connection successful
        echo "Connection successful";
    }

$showAlert = false;  
$showError = false;  
$exists=false; 
    
if($_SERVER["REQUEST_METHOD"] == "POST") { 
      
    // Include file which makes the 
    // Database Connection. 
    include 'connectdb.php';    
    
    $username = $_POST["username"];  
    $password = $_POST["password"];  
    $cpassword = $_POST["cpassword"]; 
            
    
    $sql = "Select * from users where username='$username'"; 
    
    $result = mysqli_query($conn, $sql); 
    
    $num = mysqli_num_rows($result);  
    
    // This sql query is use to check if 
    // the username is already present  
    // or not in our Database 
    if($num == 0) { 
        if(($password == $cpassword) && $exists==false) { 
     
                
            // Password Hashing is used here.  
            $sql = "INSERT INTO `users` ( `username`,  
                `password`,) VALUES ('$username',  
                '$password',)"; 
    
            $result = mysqli_query($conn, $sql); 
    
            if ($result) { 
                $showAlert = true;  
            } 
        }  
        else {  
            $showError = "Passwords do not match";  
        }       
    }// end if  
    
   if($num>0)  
   { 
      $exists="Username not available";  
   }  
    
}//end if    
?>