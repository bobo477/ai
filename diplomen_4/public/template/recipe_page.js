document.addEventListener('DOMContentLoaded', () => {
    const recipeId = new URLSearchParams(window.location.search).get('id');
    if (recipeId) {
        fetchRecipeById(recipeId);
    }
});

async function fetchRecipeById(id) {
    try {
        const response = await fetch(`/diplomen_4/public/template/get_recipe.php?id=${id}`);
        if (!response.ok) {
            throw new Error('Recipe not found');
        }
        const recipe = await response.json();
        displayRecipe(recipe);
    } catch (error) {
        console.error('Error fetching recipe:', error);
        const recipeContainer = document.querySelector('.recipe-container');
        if (recipeContainer) {
            recipeContainer.innerHTML = '<p>Recipe not found. Please try again later.</p>';
        }
    }
}

function displayRecipe(recipe) {
    const recipeContainer = document.querySelector('.recipe-container');
    recipeContainer.innerHTML = `
        <div class="header">
            <img src="${recipe.image}" alt="${recipe.Name}" class="recipe-image">
            <div class="recipe-info">
                <div class="recipe-times">
                    <p>Cook Time: ${recipe.Time} </p>
                </div>
                <div class="recipe-ingredients">
                    <h2>Ingredients</h2>
                    <ul>
                        ${recipe.ingredients.map(ingredient => `<li>${ingredient.Name} - ${ingredient.Measurement}</li>`).join('')}
                    </ul>
                </div>
                <div class="recipe-instructions">
                    <h2>Instructions</h2>
                    <p>${recipe.Instructions}</p>
                </div>
            </div>
        </div>
        <div class="favorite-icon" onclick="toggleFavorite(${recipe.ID})">
            <img src="/diplomen_4/public/icons/favorite.png" alt="Favorite" id="favoriteIcon">
        </div>
    `;
}

function toggleFavorite(recipeId) {
    const favoriteIcon = document.getElementById('favoriteIcon');
    const isFavorite = favoriteIcon.src.includes('favorite_filled.png');

    if (isFavorite) {
        favoriteIcon.src = '/diplomen_4/public/icons/favorite.png';
        removeFavorite(recipeId);
    } else {
        favoriteIcon.src = '/diplomen_4/public/icons/favorite_filled.png';
        addFavorite(recipeId);
    }
}

function addFavorite(recipeId) {
    fetch(`/diplomen_4/public/template/add_favorite.php?id=${recipeId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Recipe added to favorites');
        } else {
            console.error('Failed to add recipe to favorites:', data.message);
        }
    })
    .catch(error => {
        console.error('Error adding favorite:', error);
    });
}

function removeFavorite(recipeId) {
    fetch(`/diplomen_4/public/template/remove_favorite.php?id=${recipeId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Recipe removed from favorites');
        } else {
            console.error('Failed to remove recipe from favorites:', data.message);
        }
    })
    .catch(error => {
        console.error('Error removing favorite:', error);
    });
}
