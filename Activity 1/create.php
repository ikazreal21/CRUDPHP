<?php
session_start();


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

    $prodname = $_POST['product'];
    $prodtype = $_POST['prodtype'];
    $price = $_POST['price'];
    $id =  $_SESSION['user_id'];


    // Insert data into the database
    $sql = "INSERT INTO listings (User_ID, Product, Type, Price) /* refactored for fk, how the hell do i reference email now */
            VALUES ('$id', '$prodname', '$prodtype','$price')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product successfully posted. Returning to home..');</script>";
        echo "<script>setTimeout(function(){window.location.href='home.php';}, 200);</script>";
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

    </style>

    <body>

    <div class="signup-section" id="create-listing">
        <img src="octagon.png" class="hero-picture" id="signup-octagon" alt="">
        <form method="post">
            <a href="home.php" class="button" id="back-button">Back</a>
            <h1>Post a Product</h1>
            <p>Ready to sell a product? Just fill in these details <br>
                and we'll set everything else up for you.</p>
            <hr>
            <label for="product"><b>Product Name</b></label>
            <input type="text" placeholder="Enter Product Name" name="product" id="product" maxlength="24" required>
            <br>
            <label for="prodtype"><b>Product Type</b></label>
            <input type="text" placeholder="Enter Product Type" name="prodtype" id="prodtype" maxlength="24" required>
            <br>
            <label for="number"><b>Price</b></label>
            <input type="int" placeholder="Price" name="price" id="price" maxlength="8" required> <!-- debug. make it accept numbers only -->
            <br>
            <br>
            <input type="submit" value="Post" class="">
        </form>
    </div>
        
    </body>

</html>