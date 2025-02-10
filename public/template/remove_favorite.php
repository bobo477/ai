<?php
session_start();
include '../../config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$username = $_SESSION['username']; // Keep username as string
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Establish MySQLi connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check the connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Get user_id from the username stored in session
    $query = "SELECT ID FROM users WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username); // Bind the username as string
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if (!$user_id) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit();
    }

    // Prepare query to remove the favorite
    $query = "DELETE FROM user_favorites WHERE UsersID = ? AND RecipeID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $recipe_id);
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Favorite not found']);
    }

} catch (Exception $e) {
    // Handle errors gracefully
    echo json_encode(['success' => false, 'message' => 'Error removing from favorites: ' . $e->getMessage()]);
} finally {
    // Ensure resources are properly closed
    if (isset($stmt)) {
        $stmt->close();
    }
    $db->close();
}
?>
