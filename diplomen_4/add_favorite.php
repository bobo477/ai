<?php
session_start(); // Start the session
include '../../config.php'; // Include configuration file

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Get the logged-in user's username and recipe ID from the request
$username = $_SESSION['username']; // Get username from session
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Get recipe ID from URL

// Validate recipe ID
if ($recipe_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable MySQLi error reporting

try {
    // Establish MySQLi connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check the connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare the query to add the recipe to the user's favorites
    $query = "INSERT INTO user_favorites (UsersID, RecipeID) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $username, $recipe_id); // Bind username and recipe ID

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add to favorites']);
    }

    // Close statement and connection
    $stmt->close();
    $db->close();
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(['success' => false, 'message' => 'Error adding to favorites: ' . $e->getMessage()]);
}
?>
