//add border to navbar when scrolled
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', function() {
    if (window.scrollY > 250) {
        navbar.classList.add('border-bottom');
        navbar.classList.add('shadow-sm');
    } else {
        navbar.classList.remove('border-bottom');
        navbar.classList.remove('shadow-sm');
    }
});

//search function 
document.getElementById('searchBar').addEventListener('keyup', function(e) {
    e.preventDefault();
    if (e.key === 'Enter') {        window.location.href = 'http://localhost:8000/recipes/search/' + document.getElementById('searchBar').value;
    }
});
