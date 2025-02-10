<?php
session_start();
include '../../config.php';

// Database connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch recipes from the database
$query = "SELECT ID, Name FROM RECIPE"; // Adjust the columns based on your database schema
$result = $db->query($query);

// Store recipes in an array
$recipes = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}
$db->close();

// Hardcoded image paths for recipes
$imagePaths = [
    "Салата Цезар" => "/diplomen_4/public/photos/483f56e817516380c9a43c82e2a7ff92.jpg",
    "Гръцка салата" => "/diplomen_4/public/photos/483f56e817516380c9a43c82e2a7ff92.jpg",
    "Салата Капрезе" => "/diplomen_4/public/photos/483f56e817516380c9a43c82e2a7ff92.jpg",
    "Салата Нисоаз" => "/diplomen_4/public/photos/483f56e817516380c9a43c82e2a7ff92.jpg",
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spring Recipes</title>
  <link rel="stylesheet" href="\diplomen_4\public\recipes-pages\recipes.css">
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
          <li><a href="/diplomen_4/public/popular-page/popular.php" class="header-text popular">Popular</a></li>
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
    <div class="container">
      <h1>Популярни   </h1>
      <div class="recipes_lols">
        <?php foreach ($recipes as $recipe) { 
          // Get the image path for the current recipe
          $imagePath = isset($imagePaths[$recipe['Name']]) ? $imagePaths[$recipe['Name']] : "/diplomen_4/public/photos/5e24db6215db855d7e036741cb5c115d.jpg";
        ?>
          <div class="recipe-box">
            <a href="/diplomen_4/public/template/recipe_page.php?id=<?php echo $recipe['ID']; ?>" class="recipe-link">
              <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($recipe['Name']); ?>">
              <h2><?php echo htmlspecialchars($recipe['Name']); ?></h2>
              <p>Време за приготвяне: <?php echo isset($recipe['PreparationTime']) ? htmlspecialchars($recipe['PreparationTime']) : "N/A"; ?> мин</p>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
      <span class="footer-text">All rights reserved ®</span>
    </footer>
  </div>
</body>
</html>
