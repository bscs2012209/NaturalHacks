function img(anything) {
    document.querySelector('.slide').src = anything;
}

function change(change) {
    const line = document.querySelector('.home');
    line.style.background = change;
}

function mark_rating(value) {
    const stars = document.querySelectorAll('.hover-star');
    stars.forEach((star, index) => {
        star.style.filter = index < value ? 'grayscale(0%)' : 'grayscale(100%)';
    });
    document.querySelector('.rating_star').value = value;
    document.querySelector('.rating').innerText = `(${value})`;
}

function show_rating(value) {
    const stars = document.querySelectorAll('.hover-star');
    stars.forEach((star, index) => {
        star.style.filter = index < value ? 'grayscale(0%)' : 'grayscale(100%)';
    });
}

function hide_rating() {
    const start_value = document.querySelector('.rating_star').value;
    const stars = document.querySelectorAll('.hover-star');
    stars.forEach((star, index) => {
        star.style.filter = index < start_value ? 'grayscale(0%)' : 'grayscale(100%)';
    });
}

// let header = document.querySelector('header');
// window.addEventListener('scroll', () => {
//     header.classList.toggle('shadow', window.scrollY > 0);
// });
