<?php

session_start();
include '../../config.php';

header('Content-Type: application/json');

// Database connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection error', 'details' => $db->connect_error]);
    exit();
}

$recipeId = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($recipeId) {
    // Fetch the recipe from the database
    $stmt = $db->prepare("SELECT ID, Name, Time, Instructions FROM RECIPE WHERE ID = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $recipe = $stmt->get_result()->fetch_assoc();

    if ($recipe) {
        // Fetch ingredients for the recipe
        $stmt = $db->prepare("SELECT i.Name, i.Measurement FROM Ingredients i JOIN RECIPE_INGREDIENTS ri ON i.ID = ri.IngredientID WHERE ri.RecipeID = ?");
        $stmt->bind_param("i", $recipeId);
        $stmt->execute();
        $ingredients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // Add ingredients to the recipe data
        $recipe['ingredients'] = $ingredients;

        // Send the recipe data as JSON
        echo json_encode($recipe);
    } else {
        // Recipe not found
        http_response_code(404);
        echo json_encode(['error' => 'Recipe not found', 'recipeId' => $recipeId]);
    }
} else {
    // Recipe ID not provided
    http_response_code(400);
    echo json_encode(['error' => 'Recipe ID not provided']);
}

$stmt->close();
$db->close();