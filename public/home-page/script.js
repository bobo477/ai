// Function to filter recipes based on the search input
function searchRecipes() {
   const input = document.getElementById('searchInput').value.toLowerCase();
  const recipes = document.querySelectorAll('.recipe-box');
  
  recipes.forEach(function(recipe) {
      const recipeName = recipe.querySelector('h2').textContent.toLowerCase();
      
      if (recipeName.includes(input)) {
          recipe.style.display = ''; // Show the recipe if it matches
      } else {
          recipe.style.display = 'none'; // Hide the recipe if it doesn't match
      }
  });
}

// Function to toggle search bar visibility
function toggleSearch() {
  const searchBar = document.getElementById('searchBar');
  const navLinks = document.getElementById('navLinks');
  const searchIcon = document.getElementById('searchIcon');

  // Toggle search bar visibility
  searchBar.classList.toggle('show-search');
  
  // Slide the nav links when search bar is shown
  navLinks.classList.toggle('shift-left');
  searchIcon.classList.toggle('hidden'); // Toggle the hidden class

  // Toggle the position class
  searchBar.classList.toggle('align-right');
}
