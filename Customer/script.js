document.getElementById('searchBar').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const restaurants = document.querySelectorAll('.restaurant');

    restaurants.forEach(restaurant => {
        const name = restaurant.querySelector('h3').innerText.toLowerCase();
        if (name.includes(searchTerm)) {
            restaurant.style.display = 'block';
        } else {
            restaurant.style.display = 'none';
        }
    });
});
