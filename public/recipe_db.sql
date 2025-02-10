-- create RECIPE table
CREATE TABLE RECIPE (
  ID INTEGER PRIMARY KEY,
  Name TEXT NOT NULL,
  Time TEXT NOT NULL,
  Instructions TEXT NOT NULL
);

-- create Ingredients table
CREATE TABLE Ingredients (
  ID INTEGER PRIMARY KEY,
  Name TEXT NOT NULL,
  Measurement TEXT NOT NULL
);

-- create RECIPE_INGREDIENTS table
CREATE TABLE RECIPE_INGREDIENTS (
  RecipeID INTEGER,
  IngredientID INTEGER,
  FOREIGN KEY (RecipeID) REFERENCES RECIPE(ID),
  FOREIGN KEY (IngredientID) REFERENCES Ingredients(ID)
);


CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `PasswordHash` text NOT NULL
);

-- create Favourites table
CREATE TABLE Favourites (
  UsersID INTEGER,
  RecipeID INTEGER,
  FOREIGN KEY (UsersID) REFERENCES Users(ID),
  FOREIGN KEY (RecipeID) REFERENCES RECIPE(ID)
);

-- insert values into Ingredients table
INSERT INTO Ingredients VALUES
(1, 'Pasta', '200g'),
(2, 'Bacon', '100g'),
(3, 'Eggs', '2'),
(4, 'Cheese', '50g'),
(5, 'Pizza Dough', '1 piece'),
(6, 'Tomato Sauce', '100g'),
(7, 'Mozzarella Cheese', '200g'),
(8, 'Lettuce', '1 head'),
(9, 'Croutons', '50g'),
(10, 'Caesar Dressing', '100ml');

-- insert values into RECIPE table
INSERT INTO RECIPE VALUES
(1, 'Pasta Carbonara', '20 mins', 'Boil pasta. Cook bacon. Mix eggs and cheese. Combine.'),
(2, 'Margarita Pizza', '45 mins', 'Prepare dough. Add toppings. Bake.'),
(3, 'Caesar Salad', '15 mins', 'Prepare dressing. Toss with lettuce and croutons.');

-- insert values into RECIPE_INGREDIENTS table
INSERT INTO RECIPE_INGREDIENTS VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 7),
(3, 8),
(3, 9),
(3, 10);

-- select to display ingredients for a given recipe
SELECT r.Name AS Recipe_Name, i.Name AS Ingredient_Name, i.Measurement
FROM RECIPE r
JOIN RECIPE_INGREDIENTS ri ON r.ID = ri.RecipeID
JOIN Ingredients i ON ri.IngredientID = i.ID
WHERE r.Name = 'Margarita Pizza';