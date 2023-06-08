<?php

$uname1 = $_POST['uname1'];
$uname2 = $_POST['uname2'];
$email  = $_POST['email'];
$gender = $_POST['gender'];
$upswd1 = $_POST['upswd1'];
$upswd2 = $_POST['upswd2'];



$upswd1=password_hash($upswd1, PASSWORD_DEFAULT);
$upswd2=password_hash($upswd2, PASSWORD_DEFAULT);
if (!empty($uname1) || !empty($uname2) || !empty($email) || !empty($gender) || !empty($upswd1) || !empty($upswd2) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "foodexpress";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From sign_up Where email = ? Limit 1";
  $INSERT = "INSERT Into sign_up (uname1 , uname2, email , gender, upswd1, upswd2 )values(?,?,?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssssss", $uname1,$uname2,$email,$gender,$upswd1,$upswd2);
      $stmt->execute();
      echo "Created Successfully";
     } else {
      echo "Invalid Email or Password";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>