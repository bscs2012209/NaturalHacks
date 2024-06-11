let search = document.querySelector('.search-box');

document.querySelector('#search-icon').onclick = () => {
    search.classList.toggle('active');
    menu.classList.remove('active');
}

let menu = document.querySelector('.navbar');

document.querySelector('#menu-icon').onclick = () => {
    menu.classList.toggle('active');
    search.classList.remove('active');
}
//Hide menu and Search Box on Scroll
window.onscroll = () =>{
    menu.classList.remove('active');
    search.classList.remove('active');
}



//Header
let header = document.querySelector('header');
window.addEventListener('scroll', () => {
    header.classList.toggle('shadow',window.scrollY > 0);
});

var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
      delay: 7500,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    loop:true,
  });


  function isJSON(str) {
    try {
        JSON.parse(str);
        return true;
    } catch (e) {
        return false;
    }
}

function searchCall(value) {
    if (value.trim() === '') {
        document.getElementById('searchOptions').innerHTML = '';
        return;
    }

    fetch('./index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'search_query=' + value,
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('searchOptions').innerHTML = '';

            if (data.length > 0) {
                data.forEach(result => {
                    let html = `<li>`;
                    if (isJSON(result.image)) {
                        const images = JSON.parse(result.image);
                        html += `<a href="http://localhost/FypProject/disease_remedy_detail.php?id=${result.id}" class="searchResultAnchor"><img src="${images[0]}"><h4>${result.name}</h4></a>`;
                    } else {
                        html += `<a href="http://localhost/FypProject/disease_detail.php?id=${result.id}" class="searchResultAnchor"><img src="${result.image}"><h4>${result.name}</h4></a>`;
                    }
                    html += '</li>';

                    document.getElementById('searchOptions').innerHTML += html; // Adding results in HTML, Sary Li ek jagah save kerwaye 
                });
            } else {
                document.getElementById('searchOptions').innerHTML = `<li >
        <h4 style="text-align: center; width: 100%;">No results found</h4>
    </li>
    `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}