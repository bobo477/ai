<?php
session_start();
include '../../config.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {  // Use $_SESSION['username'] if that's what you store
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$username = $_SESSION['username']; // Retrieve the username from session
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
    exit();
}

// Connect to the database
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch the user_id from the username
$query = "SELECT ID FROM users WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

// Prepare the query to remove the favorite
$query = "DELETE FROM user_favorites WHERE UsersID = ? AND RecipeID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $user_id, $recipe_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove favorite']);
}

$stmt->close();
$db->close();
?>
