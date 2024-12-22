<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection details
    $servername = "localhost";
    $username = "root"; // Default XAMPP username
    $password = ""; // Default XAMPP password
    $dbname = "test";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $email = $_POST['email'];
    $name = $_POST['uname'];
    $number = $_POST['number'];
    $password = $_POST['pass'];
    $hashed_password = password_hash($_POST['pass'], PASSWORD_DEFAULT);


    // Insert data into the database
    $sql = "INSERT INTO users (email, name, number, password) 
            VALUES ('$email', '$name','$number', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! Please head to the login page to log in.');</script>";
        echo "<script>setTimeout(function(){window.location.href='index.html';}, 200);</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    // Close connection
    $conn->close();
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>
            Ahente: The Salesperson Application
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            
        }
        #back-button {
            margin-top: 100px; /* problematic */
        }

        .signup-section {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
            background-color: white;
            padding: 50px 0;
            margin: 0 300px;
            border: 3px solid black;
            border-radius: 10px;
        }

        .random-box {
            width: 100%;
            max-width: 400px;
            height: 100%;
            max-height: 200px;
            color: blanchedalmond;
        }

        form {   
            padding: 20px;
            border: 3px solid #000000;
        }
        input[type="text"], input[type="password"], input[type="tel"] {
            width: 100%;
            max-width: 200px;
            padding: 10px 0 10px 5px;
            margin: 15px 0;
            border: 3px solid #000000;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            background-color: #f1f1f1;
            outline: none;
        }
        button {
            background-color: rgb(168, 16, 16);
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            opacity: 0.9;
        }

        #signup-octagon {
            margin-left: 0;
            margin-right: 50px;
            background-color: white;
        }
    </style>

</head>
<body>
    <div class="signup-section">
        <img src="octagon.png" class="hero-picture" id="signup-octagon" alt="">
        <form action="signup.php" method="post">
            <a href="index.html" class="button" id="back-button">Back</a>
            <h1>Sign Up</h1>
            <p>To create an account, please input the following fields with your data.</p>
            <hr>
            <label for="uname"><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="uname" id="uname" maxlength="24" required>
            <br>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" maxlength="24" required>
            <br>
            <label for="number"><b>Number</b></label>
            <input type="tel" placeholder="Number" name="number" id="number" maxlength="11" required> <!-- debug. make it accept numbers only -->
            <br>
            <label for="pass"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pass" id="pass" maxlength="16" required>
            <br>
            <br>
            <br>
            <input type="submit" value="Sign Up" class="">
        </form>
    </div>
</body>
</html>