<?php
session_start();
include '../../config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['users_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$users_id = $_SESSION['users_id']; // Use users_id from the session
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid recipe ID']);
    exit();
}

try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }

    // Prepare query to remove the favorite
    $query = "DELETE FROM favorites WHERE users_id = ? AND recipe_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $users_id, $recipe_id); // Use integer bindings
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Recipe removed from favorites']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Favorite not found']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error removing from favorites: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($db)) {
        $db->close();
    }
}
?>
