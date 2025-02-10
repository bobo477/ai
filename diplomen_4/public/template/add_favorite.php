<?php
session_start();
include '../../config.php';

header('Content-Type: application/json');

// Ensure the user is logged in
if (!isset($_SESSION['users_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$users_id = $_SESSION['users_id']; // Fetch the correct user ID
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
    exit();
}

// Connect to the database
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $db->connect_error]);
    exit();
}

// Check if the recipe is already favorited
$query_check = "SELECT * FROM favorites WHERE users_id = ? AND recipe_id = ?";
$stmt_check = $db->prepare($query_check);
$stmt_check->bind_param("ii", $users_id, $recipe_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Recipe already in favorites']);
    $stmt_check->close();
    $db->close();
    exit();
}

// Prepare the query to add the favorite
$query = "INSERT INTO favorites (users_id, recipe_id) VALUES (?, ?)";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $users_id, $recipe_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Recipe added to favorites']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add favorite']);
}

$stmt->close();
$db->close();
?>
