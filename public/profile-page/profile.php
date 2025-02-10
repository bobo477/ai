<?php
session_start();
require_once '../../config.php'; // Include database configuration

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /diplomen_4/public/log-in/log_in.php');
    exit();
}

// Fetch user information from the database
$username = $_SESSION['user'];
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Enable MySQLi error reporting for debugging during development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Fetch user's profile information
$stmt = $db->prepare("SELECT FirstName, LastName, Email FROM users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $email);
$stmt->fetch();
$stmt->close();

// Fetch favorite recipes
$favorites_query = "SELECT r.ID, r.Name, r.Time, r.Instructions 
                    FROM recipe r 
                    JOIN user_favorites uf ON r.ID = uf.recipe_id 
                    WHERE uf.username = ?";
$favorites_stmt = $db->prepare($favorites_query);
$favorites_stmt->bind_param("s", $username);
$favorites_stmt->execute();
$favorites_result = $favorites_stmt->get_result();
$favorites = $favorites_result->fetch_all(MYSQLI_ASSOC);
$favorites_stmt->close();

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400&family=Jost:ital,wght@1,500&display=swap"
    />
    <link rel="stylesheet" href="/diplomen_4/public/profile-page/profile.css" />
    <title>Profile</title>
  </head>
  <body>
    <div class="page-container">
      <!-- Header Section -->
      <nav class="header-container">
        <div class="logo">
          <span class="logo-text">Logo</span>
        </div>
        <ul class="nav-links" id="navLinks">
          <li><a href="/diplomen_4/public/home-page/home_page_logged.php" class="header-text home">Home</a></li>
          <li><a href="/diplomen_4/public/recipes-pages/recipes_logged.php" class="header-text recipes">Recipes</a></li>
          <li><a href="/diplomen_4/public/popular-page/popular_logged.php" class="header-text popular">Popular</a></li>
          <li><a href="/diplomen_4/public/log-in/log_out.php" class="header-text log out"><img src="/diplomen_4/public/icons/logout.png" alt="Log out" style="width: 24px; height: 24px;"></a></li>
        </ul>
      </nav>

      <!-- Main Content -->
      <div class="main-container">
        <div class="profile-container">
          <h2>Profile</h2>
          <div class="profile-info">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstname); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastname); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
          </div>
          <h2>Favorite Recipes</h2>
          <div class="favorites">
            <?php if (!empty($favorites)) { ?>
              <ul>
                <?php foreach ($favorites as $favorite) { ?>
                  <li>
                    <a href="/diplomen_4/public/template/recipe_page.php?id=<?php echo htmlspecialchars($favorite['ID']); ?>">
                      <h3><?php echo htmlspecialchars($favorite['Name']); ?></h3>
                      <p><strong>Time:</strong> <?php echo htmlspecialchars($favorite['Time']); ?></p>
                      <p><strong>Instructions:</strong> <?php echo htmlspecialchars($favorite['Instructions']); ?></p>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            <?php } else { ?>
              <p>No favorite recipes found.</p>
            <?php } ?>
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
