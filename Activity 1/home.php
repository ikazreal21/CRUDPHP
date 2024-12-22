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
        .welcome-text {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
        }
        
        .home-buttons {
            margin: 0 10%;
            display: flex;
            justify-content: space-evenly;
        }

        h2 {
            margin-left: 10px;
        }


    </style>

    <body>
        
        <div class="welcome-text">
            <?php
            session_start();

            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page if not logged in
                header("Location: login.php");
                exit();
            }
            
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['user_name'];
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "test";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT Name FROM users WHERE ID = `$user_id`"; // Change the ID as needed
                $result = $conn->query($sql);
                

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $user_name = $row["name"];
                    }
                } else {
                    $user_name = "User  not found";
                }

                $conn->close();
            }
            ?>
            <p>Welcome, <?php echo htmlspecialchars($user_name); ?>. We missed you.</p>
            <h2>Let's start selling!</h2>
        </div>

        <div class="home-buttons">
            <a href="create.php" class="button" id="createlist-button">Create Listing</a> 
            <a href="read.php" class="button" id="viewlist-button">View All Listings</a>
            <!-- <a href="update.php" class="button" id="updatelist-button">Update Listing</a>  -->
            <!-- i need update (and if possible delete) ASAP -->
            <!-- <a href="index.html" class="button" id="deletelist-button">Delete Listing</a>  -->
            <!-- sa bahay mo na gawin muna yung full view logic -->
        </div>
        
    </body> <!-- fix tables first and foremost -->
</html>