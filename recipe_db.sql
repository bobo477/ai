-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 12:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Measurement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ID`, `Name`, `Measurement`) VALUES
(1, 'Pasta', '200g'),
(2, 'Bacon', '100g'),
(3, 'Eggs', '2'),
(4, 'Cheese', '50g'),
(5, 'Pizza Dough', '1 piece'),
(6, 'Tomato Sauce', '100g'),
(7, 'Mozzarella Cheese', '200g'),
(8, 'Lettuce', '1 head'),
(9, 'Croutons', '50g'),
(10, 'Caesar Dressing', '100ml'),
(11, 'Chicken', '200g'),
(12, 'Alfredo Sauce', '100ml'),
(13, 'Mixed Vegetables', '300g'),
(14, 'Soy Sauce', '50ml'),
(15, 'Beef', '250g'),
(16, 'Taco Shells', '6 pieces'),
(17, 'Salsa', '50g'),
(18, 'Spaghetti', '200g'),
(19, 'Ground Beef', '200g'),
(20, 'Tomato Sauce', '100ml'),
(21, 'Bread', '2 slices'),
(22, 'Butter', '20g'),
(23, 'Shrimp', '150g'),
(24, 'Garlic', '3 cloves'),
(25, 'Flour', '100g'),
(26, 'Milk', '200ml'),
(27, 'Eggs', '1'),
(28, 'Vegetables', '200g'),
(29, 'Heavy Cream', '50ml'),
(30, 'Curry Paste', '50g'),
(31, 'Noodles', '200g');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Time` text NOT NULL,
  `Instructions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`ID`, `Name`, `Time`, `Instructions`) VALUES
(1, 'Pasta Carbonara', '20 mins', 'Boil pasta. Cook bacon. Mix eggs and cheese. Combine.'),
(2, 'Margarita Pizza', '45 mins', 'Prepare dough. Add toppings. Bake.'),
(3, 'Caesar Salad', '15 mins', 'Prepare dressing. Toss with lettuce and croutons.'),
(4, 'Chicken Alfredo', '30 mins', 'Cook pasta. Prepare Alfredo sauce. Combine with chicken.'),
(5, 'Vegetable Stir Fry', '25 mins', 'Chop vegetables. Stir fry with sauce. Serve.'),
(6, 'Beef Tacos', '35 mins', 'Prepare taco shells. Cook beef. Assemble tacos.'),
(7, 'Spaghetti Bolognese', '40 mins', 'Cook spaghetti. Prepare bolognese sauce. Combine and serve.'),
(8, 'Grilled Cheese Sandwich', '10 mins', 'Butter bread. Add cheese. Grill until golden.'),
(9, 'Chicken Curry', '50 mins', 'Cook chicken. Prepare curry sauce. Combine and simmer.'),
(10, 'Tomato Soup', '30 mins', 'Cook tomatoes. Blend. Simmer with spices and cream.'),
(11, 'Beef Stroganoff', '45 mins', 'Cook beef. Prepare stroganoff sauce. Serve with noodles.'),
(12, 'Vegetarian Pizza', '40 mins', 'Prepare dough. Add vegetables and cheese. Bake.'),
(13, 'Shrimp Scampi', '25 mins', 'Cook shrimp. Prepare garlic butter sauce. Serve with pasta.'),
(14, 'Pancakes', '20 mins', 'Mix batter. Cook on skillet. Serve with syrup.');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `RecipeID` int(11) DEFAULT NULL,
  `IngredientID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`RecipeID`, `IngredientID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 7),
(3, 8),
(3, 9),
(3, 10),
(4, 1),
(4, 11),
(4, 12),
(5, 13),
(5, 14),
(6, 15),
(6, 16),
(6, 17),
(7, 18),
(7, 19),
(7, 20),
(8, 21),
(8, 22),
(8, 7),
(9, 11),
(9, 30),
(9, 29),
(10, 20),
(10, 29),
(11, 15),
(11, 31),
(12, 5),
(12, 6),
(12, 28),
(13, 23),
(13, 24),
(13, 1),
(14, 25),
(14, 26),
(14, 27);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `PasswordHash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FirstName`, `LastName`, `email`, `username`, `PasswordHash`) VALUES
(0, 'Boris', 'Tsankov', 'bhasdfjsh!@gmail.com', 'bobo', '$2y$10$wlrt/i.W705oCkOJw3SR2uJpgRIGftwPbf.M5f/9hZ2tAhoQWc5lG'),
(0, 'b', 'q', 'loll@gmail.com', 'b', '$2y$10$zl2hgC4oFCh2VUZSPct4kuGq.tM/NgiFf/kZvUMDJMFBsE/dlyV4W'),
(0, 'a', 'a', 'aa@gmail.com', 'a', '$2y$10$AK7vd19o8b0w4h4.mSbGNOO/GgvraeyAn9iZNv/KYc2sJQF2gTznO'),
(0, 'c', 'c', 'c@gmail.com', 'c', '$2y$10$./S.7lJFDyPplVEojQKywOQEX/.ckvy3RxEKzaMDvzDZeMALM3hoG');

-- --------------------------------------------------------

--
-- Table structure for table `user_favorites`
--

CREATE TABLE `user_favorites` (
  `ID` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD KEY `RecipeID` (`RecipeID`),
  ADD KEY `IngredientID` (`IngredientID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_user_favorites_user_id` (`users_id`),
  ADD KEY `fk_user_favorites_recipe_id` (`recipe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe_ingredients_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`ID`),
  ADD CONSTRAINT `recipe_ingredients_ibfk_2` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`ID`);

--
-- Constraints for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `fk_user_favorites_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_favorites_user_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
