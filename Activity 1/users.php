<?php
$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];
$password = $_POST['password'];


$conn = new mysqli('localhost','root','','test');
    if($conn->connect_error){
        die('Connection Failed :'.$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("Insert Into users(email,password) values(?,?)");
        $stmt->bind_param("ssss", $name, $email, $number, $password);
        $stmt->execute();
        echo "Sign Up Complete!!!";
        $stmt->close();
        $conn->close();
    }
?>