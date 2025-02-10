<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

session_start();
header('Content-Type: application/json');

include 'config.php';

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get the recipe ID from the request
$recipeID = isset($_POST['recipeID']) ? intval($_POST['recipeID']) : 0;
$userID = $_SESSION['username'];

// Check if the recipe is already favorited
$sql_check = "SELECT * FROM user_favorites WHERE  = ? AND recipe_id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ii", $userID, $recipeID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Recipe is already favorited, so remove it
    $sql_delete = "DELETE FROM user_favorites WHERE username = ? AND recipe_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("ii", $userID, $recipeID);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Recipe removed from favorites', 'isFavorite' => false]);
} else {
    // Recipe is not favorited, so add it
    $sql_insert = "INSERT INTO user_favorites (username, recipe_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ii", $userID, $recipeID);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Recipe added to favorites', 'isFavorite' => true]);
}

$stmt->close();
$conn->close();
?>
