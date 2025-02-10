  const express = require('express');
const mysql = require('mysql2');
const bcrypt = require('bcryptjs');
const bodyParser = require('body-parser');
const path = require('path');
const session = require('express-session');

const app = express();
const port = 3000;

// Static Middleware
app.use(express.static(path.join(__dirname, 'public')));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(session({
  secret: 'Petra_239', // Replace with a secure key
  resave: false,
  saveUninitialized: true
}));

// Database connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'Petra_239', // Ensure this is correct
  database: 'recipe_db' // Ensure this is correct
});

db.connect(err => {
  if (err) {
    throw err;
  }
  console.log('MySQL connected...kanalcho@aternos.me');
});

// Middleware to check if user is logged in
function checkAuth(req, res, next) {
  if (req.session.user) {
    next();
  } else {
    res.redirect('/public/log-in/log_in.php'); // PHP version of the login page
  }
}

// User Signup Endpoint
app.post('/api/signup', async (req, res) => {
  const { firstname, lastname, username, email, password } = req.body;

  try {
    const hashedPassword = await bcrypt.hash(password, 10);

    const sql = `
      INSERT INTO users (first_name, last_name, username, email, password_hash)
      VALUES (?, ?, ?, ?, ?)
    `;
    db.query(sql, [firstname, lastname, username, email, hashedPassword], (err, result) => {
      if (err) {
        if (err.code === 'ER_DUP_ENTRY') {
          return res.status(400).json({ error: 'Username or Email already exists' });
        }
        return res.status(500).json({ error: err.message });
      }
      res.redirect('/public/home-page/home_page_logged.php'); // PHP version of the logged-in home page
    });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// User Login Endpoint
app.post('/api/login', (req, res) => {
  const { username, password } = req.body;

  const sql = `
    SELECT * FROM users WHERE username = ?
  `;

  db.query(sql, [username], async (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }

    if (results.length === 0) {
      return res.status(401).json({ error: 'Invalid username or password' });
    }

    const user = results[0];

    const passwordMatch = await bcrypt.compare(password, user.password_hash);
    if (!passwordMatch) {
      return res.status(401).json({ error: 'Invalid username or password' });
    }

    // Store user information in the session
    req.session.user = {
      username: user.username,
      email: user.email
    };

    res.redirect('/public/home-page/home_page_logged.php'); // PHP version of the logged-in home page
  });
});

// Serve home page based on login status
app.get('/home-page/home_page.html', (req, res) => {
  const isLoggedIn = req.session.user ? true : false;
  if (isLoggedIn) {
    res.redirect('/public/home-page/home_page_logged.php');
  } else {
    res.sendFile(path.join(__dirname, 'public/home-page/home_page.php')); // PHP version of the home page
  }
});

// Serve logged-in home page
app.get('/home-page/home_page_logged.html', checkAuth, (req, res) => {
  res.sendFile(path.join(__dirname, 'public/home-page/home_page_logged.php')); // PHP version of the logged-in home page
});

// Serve recipes page
app.get('/recipes-pages/recipes.html', (req, res) => {
  const isLoggedIn = req.session.user ? true : false;
  if (isLoggedIn) {
    res.sendFile(path.join(__dirname, 'public/recipes-pages/recipes_logged.php')); // PHP version of the logged-in recipes page
  } else {
    res.sendFile(path.join(__dirname, 'public/recipes-pages/recipes.php')); // PHP version of the recipes page
  }
});

// Serve popular page
app.get('/popular-page/popular.html', (req, res) => {
  const isLoggedIn = req.session.user ? true : false;
  if (isLoggedIn) {
    res.sendFile(path.join(__dirname, 'public/popular-page/popular_logged.php')); // PHP version of the logged-in popular page
  } else {
    res.sendFile(path.join(__dirname, 'public/popular-page/popular.php')); // PHP version of the popular page
  }
});

// Serve favourites page (only accessible to logged-in users)
app.get('/favourites-page/favourites.html', checkAuth, (req, res) => {
  res.sendFile(path.join(__dirname, 'public/favourites-page/favourites.php')); // PHP version of the favourites page
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
