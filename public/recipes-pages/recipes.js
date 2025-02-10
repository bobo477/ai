// Function to filter recipes based on the search input
function searchRecipes() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const recipeBoxes = document.querySelectorAll('.recipe-box');
    
    recipeBoxes.forEach(box => {
        const title = box.querySelector('h2').textContent.toLowerCase();
        if (title.includes(input)) {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });
}

// Function to toggle the search input visibility
function toggleSearch() {
    const searchBar = document.getElementById('searchBar');
    const navLinks = document.getElementById('navLinks');
    const searchIcon = document.getElementById('searchIcon');
    searchBar.classList.toggle('show-search');
    navLinks.classList.toggle('shift-left');
    searchIcon.classList.toggle('hidden'); // Toggle the hidden class
}
