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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <body>
        <h1>All Listings</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- User_ID -->
                    <th>Name</th> <!-- User_Name -->
                    <th>Product</th>
                    <th>Type</th>
                    <th>Price</th>
                </tr>
            </thead>

            <tbody>
                <?php
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
                    
                    $sql = "SELECT listings.*, users.name AS User_Name FROM listings INNER JOIN users ON listings.User_ID = users.ID;";
                    $result = $conn -> query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["User_ID"] . "</td>
                                <td>" . $row["User_Name"] . "</td>
                                <td>" . $row["Product"] . "</td>
                                <td>" . $row["Type"] . "</td>
                                <td>" . $row["Price"] . "</td>
                                <td>
                                    <a href='update.php?id=" . $row["id"] . "'>
                                        <button>Update</button>
                                    </a>
                                    <a href='delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>
                                        <button>Delete</button>
                                    </a>
                                </td>
                                </tr>";
                        }
                    } else {
                        $user_name = "User  not found";
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>