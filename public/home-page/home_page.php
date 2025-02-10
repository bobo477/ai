<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="/diplomen_4/public/home-page/home_page.css">
  <script src="/diplomen_4/public/scripts/script.js" defer></script>
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
    <div class="main-container">
        <!-- Image Gallery Section -->
        <div class="gallery-container">
          <div class="gallery-item">
            <a href="/diplomen_4/public/season-pages/spring.php">
              <div class="gallery-image spring"></div>
            </a>
            <div class="gallery-caption">Spring</div>
          </div>
          <div class="gallery-item">
            <a href="/diplomen_4/public//season-pages/summer.php">
              <div class="gallery-image summer"></div>
            </a>
            <div class="gallery-caption">Summer</div>
          </div>
          <div class="gallery-item">
            <a href="/diplomen_4/public//season-pages/autumn.php">
              <div class="gallery-image autumn"></div>
            </a>
            <div class="gallery-caption">Autumn</div>
          </div>
          <div class="gallery-item">
            <a href="/diplomen_4/public//season-pages/winter.php">
              <div class="gallery-image winter"></div>
            </a>
            <div class="gallery-caption">Winter</div>
          </div>
        </div>
      </div>


    <!-- Footer Section -->
    <footer class="footer">
      <span class="footer-text">All rights reserved ®</span>
    </footer>
  </div>
</body>
</html>
