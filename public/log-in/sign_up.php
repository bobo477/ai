<?php
session_start();
require_once '../../config.php'; // Include database configuration

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Database connection
  $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  // Check for duplicate username or email
  $stmt = $db->prepare("SELECT id FROM users WHERE Username = ? OR Email = ?");
  $stmt->bind_param("ss", $username, $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $error = 'Username or email already exists.';
  } else {
    // Prepare and bind
    $stmt = $db->prepare("INSERT INTO users (FirstName, LastName, Username, Email, PasswordHash) VALUES (?, ?, ?, ?, ?)");
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $hashedPassword);

    if ($stmt->execute()) {
      // Registration successful, start a new session
      $_SESSION['user'] = $username;

      // Redirect user to the logged-in home page
      header('Location: /diplomen_4/public/home-page/home_page_logged.php');
      exit();
    } else {
      $error = 'Error during registration. Please try again.';
    }
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
    <title>Sign Up</title>
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
          <li><a href="/diplomen_4/public/recipes-pages/recipes.php" class="header-text recipes">Recipes</a></li>
          <li><a href="/diplomen_4/public/popular-page/popular.php" class="header-text popular">Popular</a></li>
          <li><a href="/diplomen_4/public/log-in/log_in.php" class="header-text log in">Log in</a></li>
        </ul>
      </nav>

      <!-- Main Content -->
      <div class="main-container">
        <div class="login-container">
          <h2>Sign Up</h2>
          <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
          <?php endif; ?>
          <form action="/diplomen_4/public/log-in/sign_up.php" method="post">
            <div class="form-group">
              <label for="firstname">First Name:</label>
              <input type="text" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
              <label for="lastname">Last Name:</label>
              <input type="text" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Sign Up</button>
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
