<?php
session_start();
require_once '../../config.php';

error_log('Session data: ' . print_r($_SESSION, true)); // Logs session data to the PHP error log


// Get the recipe ID from the URL
$recipeID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate recipe ID
if ($recipeID === 0) {
    die("Invalid recipe ID. Please provide a valid recipe ID in the URL.");
}

// Database connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch recipe data from the database
$stmt = $db->prepare("SELECT ID, Name, Time, Instructions FROM RECIPE WHERE ID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();

if (!$recipe) {
    die("Recipe not found!");
}

// Fetch ingredients for the selected recipe
$stmt = $db->prepare("SELECT i.Name, i.Measurement
                      FROM Ingredients i
                      JOIN RECIPE_INGREDIENTS ri ON i.ID = ri.IngredientID
                      WHERE ri.RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$ingredients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$db->close();

// Recipe image URL (consider moving this to the database)
$recipe_images = [
    'Pasta Carbonara' => '/diplomen_4/public/photos/5e24db6215db855d7e036741cb5c115d.jpg',
    'Margarita Pizza' => '/diplomen_4/public/photos/margarita_pizza.jpg',
    'Caesar Salad' => '/diplomen_4/public/photos/caesar_salad.jpg',
];
$image_url = isset($recipe_images[$recipe['Name']]) ? $recipe_images[$recipe['Name']] : '/diplomen_4/public\photos\5e24db6215db855d7e036741cb5c115d.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['Name']); ?></title>
    <link rel="stylesheet" href="/diplomen_4/public/template/recipe_page.css">
    <script src="/diplomen_4/public/template/recipe_page.js" defer></script>
</head>
<body>
    <div class="page-container">
        <nav class="header-container">
            <div class="logo">
                <span class="logo-text">Logo</span>
            </div>
            <ul class="nav-links" id="navLinks">
                <?php if (isset($_SESSION['user'])) { ?>
                    <li><a href="/diplomen_4/public/home-page/home_page_logged.php" class="header-text home">Home</a></li>
                    <li><a href="/diplomen_4/public/profile-page/profile.php" class="header-text profile">Profile</a></li>
                    <li><a href="/diplomen_4/public/recipes-pages/recipes_logged.php" class="header-text recipes">Recipes</a></li>
                    <li><a href="/diplomen_4/public/popular-page/popular_logged.php" class="header-text popular">Popular</a></li>
                <?php } else { ?>
                    <li><a href="/diplomen_4/public/home-page/home_page.php" class="header-text home">Home</a></li>
                    <li><a href="/diplomen_4/public/log-in/log_in.php" class="header-text log in">Log in</a></li>
                    <li><a href="/diplomen_4/public/recipes-pages/recipes.php" class="header-text recipes">Recipes</a></li>
                <?php } ?>
                <li>
                    <a href="#" class="header-text search-icon" id="searchIcon" onclick="toggleSearch()">
                        <img src="/diplomen_4/public/icons/magnifying-glass.png" alt="Search" style="width: 20px; height: 20px;">
                    </a>
                </li>
            </ul>
            <div class="search-bar" id="searchBar">
                <input type="text" id="searchInput" placeholder="Search recipes...">
                <img src="/diplomen_4/public/icons/magnifying-glass.png" alt="Search" class="search-icon" onclick="searchRecipes()">
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-container" id="recipeContainer">
            <div class="recipe-container">
                <div class="header">
                    <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($recipe['Name']); ?>" class="recipe-image">
                    <div class="recipe-info">
                        <div class="recipe-times">
                            <p><strong>Cook Time:</strong> <?php echo htmlspecialchars($recipe['Time']); ?></p>
                        </div>
                        <div class="recipe-ingredients">
                            <h2>Ingredients</h2>
                            <ul>
                                <?php foreach ($ingredients as $ingredient) { ?>
                                    <li><?php echo htmlspecialchars($ingredient['Name']) . ' - ' . htmlspecialchars($ingredient['Measurement']); ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="recipe-instructions">
                            <h2>Instructions</h2>
                            <p><?php echo nl2br(htmlspecialchars($recipe['Instructions'])); ?></p>
                        </div>
                    </div>
                </div>
                <div class="favorite-icon" onclick="toggleFavorite(<?php echo $recipeID; ?>)">
                    <img src="/diplomen_4/public/icons/favorite.png" alt="Favorite" id="favoriteIcon">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
