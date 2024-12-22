<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $product_name = trim($_POST['product']);
    $product_type = trim($_POST['prodtype']);
    $price = trim($_POST['price']);
    $product_id = trim($_POST['product_id']); // Hidden input for product ID

    // Validate inputs
    if (!empty($product_name) && !empty($product_type) && is_numeric($price) && !empty($product_id)) {
        // Update query
        $sql = "UPDATE listings SET Product = ?, Type = ?, Price = ? WHERE id = ?";

        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssdi", $product_name, $product_type, $price, $product_id);

            // Execute statement
            if ($stmt->execute()) {
                echo "<script>alert('Product updated successfully!');</script>";
                header("Location: read.php");
                exit();
            } else {
                echo "<script>alert('Error updating product. Please try again.');</script>";
            }

            $stmt->close();
        }
    } else {
        echo "<script>alert('Invalid input. Please fill out all fields correctly.');</script>";
    }
}

// Fetch the product details to pre-fill the form (replace with actual product ID from query string or session)
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $sql = "SELECT * FROM listings WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    }
} else {
    echo "<script>alert('Product ID not provided.');</script>";
    header("Location: home.php");
    exit();
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
        .update-grid {
            display: grid;
        }
    </style>

    <body>
        <a href="home.php" class="button" id="back-button">Back</a>
        <h2>Update Listing</h2>
        <div class="update-grid">
            <div class="signup-section" id="update-grid-item">
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>"> <!-- Hidden product ID -->
                    <h1>Update a Product</h1>
                    <hr>
                    <label for="product"><b>Product Name</b></label>
                    <input type="text" placeholder="Enter Product Name" name="product" id="product" maxlength="24" value="<?php echo htmlspecialchars($product['Product']); ?>" required>
                    <br>
                    <label for="prodtype"><b>Product Type</b></label>
                    <input type="text" placeholder="Enter Product Type" name="prodtype" id="prodtype" maxlength="24" value="<?php echo htmlspecialchars($product['Type']); ?>" required>
                    <br>
                    <label for="price"><b>Price</b></label>
                    <input type="number" placeholder="Enter Price" name="price" id="price" maxlength="8" value="<?php echo $product['Price']; ?>" required>
                    <br><br>
                    <input type="submit" value="Update" class="button">
                </form>
            </div>
        </div>
    </body>
</html>
