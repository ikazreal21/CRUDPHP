<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Fetch user data securely
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?"); // Fetch id, name, and password
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result(); 
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo var_dump($row);
        
        // Verify the password
        if (password_verify($password, $row['Password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['ID'];
            $_SESSION['user_name'] = $row['name'];
            echo var_dump($_SESSION);
        
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ahente: The Salesperson Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        display: flex;
        justify-content: center;
    }

    .container {
        align-items: center;
    }

    .login-container {
        border: 3px solid black;
    }
</style>
<body>
    <div class="login-container">
        <form action="login.php" method="post">
            <a href="index.html" class="button" id="back-button">Back</a>
            <h1>Log In</h1>
            <p>Welcome back. Ready to experience the future once more?</p>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="pass"><br><b>Password</b></b></label>
            <input type="password" placeholder="Enter Password" name="pass" required>
            <br>
            <br>
            <input type="submit" value="Log In">
            <br>
            <label>
                <br>
                <span class="pass"><a href="#">Forgot password?</a></span>
            </label>
        </form>
    </div>
</body>
</html>