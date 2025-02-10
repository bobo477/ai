<?php
session_start();
require_once '../../config.php'; // Include database configuration

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Database connection
  $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  // Prepare the SQL statement
  $stmt = $db->prepare("SELECT id, username, PasswordHash FROM users WHERE username = ?");
  if (!$stmt) {
    die("Preparation failed: " . $db->error);
  }

  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $username, $password_hash);
    $stmt->fetch();

    if (password_verify($password, $password_hash)) {
      // Password is correct, start a new session
      $_SESSION['user'] = $username;

      header('Location: ../home-page/home_page_logged.php');
      exit();
    } else {
      $error = 'Invalid username or password.';
    }
  } else {
    $error = 'Invalid username or password.';
  }

  $stmt->close();
  $db->close();
}
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
    <link rel="stylesheet" href="/diplomen_4/public/log-in/log_in.css" />
    <title>Log In</title>
  </head>
  <body>
    <div class="page-container">
      <!-- Header Section -->
      <nav class="header-container">
        <div class="logo">
          <span class="logo-text">Logo</span>
        </div>
        <ul class="nav-links" id="navLinks">
          <li><a href="/diplomen_4/public/home-page/home_page.php" class="header-text home">Home</a></li>
          <li><a href="/diplomen_4/public/recipes-page/recipes.php" class="header-text recipes">Recipes</a></li>
          <li><a href="/diplomen_4/public/popular-page/popular.php" class="header-text popular">Popular</a></li>
          <li><a href="/diplomen_4/public/log-in/sign_up.php" class="header-text log in">Sign up</a></li>
          <li>

      </nav>

      <!-- Main Content -->
      <div class="main-container">
        <div class="login-container">
          <h2>Log In</h2>
          <form action="/diplomen_4/public/log-in/log_in.php" method="post">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required>
            </div>
            <p>Don't have a profile? <a href="/diplomen_4/public/log-in/sign_up.php">Sign up</a></p>

            <button type="submit" class="login-button">Log In</button>          
          </form>
        </div>
      </div>

      <!-- Footer Section -->
      <footer class="footer">
        <span class="footer-text">All rights reserved ®</span>
      </footer>
    </div>
  </body>
</html>