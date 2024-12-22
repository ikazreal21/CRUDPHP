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


if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Delete query
    $sql = "DELETE FROM listings WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            echo "<script>alert('Product deleted successfully!');</script>";
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Error deleting product. Please try again.');</script>";
        }

        $stmt->close();
    }
} else {
    echo "<script>alert('Product ID not provided.');</script>";
    header("Location: home.php");
    exit();
}
?>
