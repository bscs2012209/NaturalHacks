function openCart() {
    document.getElementById("mySidebar").style.width = "25vw";
    document.getElementById("mySidebar").style.marginRight = "0";
}

function closeCart() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("mySidebar").style.marginRight = "-30vw";
}

function addToCart(id) {
    const body = new URLSearchParams({ remedy_id: id, operation: 'add' });

    fetch('./assets/queries/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body,
    })
    .then(data => data.json())
    .then(response => {
        initializeCart(response.cartData);
        openCart();
})
    .catch(error => console.error('Error:', error));
}

function increaseQuantity(id) {
    const body = new URLSearchParams({ remedy_id: id, operation: 'increase' });

    fetch('./assets/queries/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body,
    })
    .then(data => data.json())
    .then(response => {
        initializeCart(response.cartData)
})
    .catch(error => console.error('Error:', error));
}

function decreaseQuantity(id) {
    const body = new URLSearchParams({ remedy_id: id, operation: 'decrease' });

    fetch('./assets/queries/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body,
    })
    .then(data => data.json())
    .then(response => initializeCart(response.cartData))
    .catch(error => console.error('Error:', error));
}

function checkOut() {
    const body = new URLSearchParams({ operation: 'checkout' });

    fetch('./assets/queries/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body,
    })
    .then(data => data.json())
    .then(response => {
        initializeCart(response);
        // Swal.fire({
        //     title: 'Checkout Successful!',
        //     text: 'Your order has been placed successfully. Redirecting to invoice...',
        //     icon: 'success',
        //     timer: 3000,
        //     showConfirmButton: false
        // }).then(() => {
            location.href = './invoice.php?id=' + response.orderId;
        // });
    })
    .catch(error => {
        console.error('Error:', error);
        // Swal.fire({
        //     title: 'Error!',
        //     text: 'There was an error processing your request. Please try again.',
        //     icon: 'error',
        //     confirmButtonText: 'Okay'
        // });
    });
}


function initialize() {

    const body = new URLSearchParams({ operation: 'initialize' });

    fetch('./assets/queries/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body,
    })
    .then(data => data.json())
    .then(response => initializeCart(response.cartData))
    .catch(error => console.error('Error:', error));
}

function initializeCart(cartDetails) {
    let totalPrice = 0;
    var cartHTML = '<div class="sidebar-header">';
    cartHTML += '<i class="bx bx-plus sidebar-close-icon" onclick="closeCart()"></i>';
    cartHTML += '<h2 class="sidebar-heading">Shopping Cart</h2>';
    cartHTML += '</div>';
    if(cartDetails.length > 0) {
    cartHTML += '<ul class="sidebar-item-list">';
    cartDetails.forEach(cart => {
        totalPrice += parseFloat(cart.price);
        cartHTML += `
            <li class="sidebar-item">
                <span>${cart.remedy_name.length < 15 ? cart.remedy_name : cart.remedy_name.substr(0, 15) + '...' } (${cart.remedy_price})</span>
                <div>
                    <button class="sidebar-quantity-update" onclick="decreaseQuantity(${cart.remedy_id})">-</button>
                    <span class="sidebar-quantity">${cart.quantity}</span>
                    <button class="sidebar-quantity-update" onclick="increaseQuantity(${cart.remedy_id})">+</button>
                </div>
            </li>
        `;
    });
    cartHTML += '</ul>';
}else{
    cartDetails += '<div class="sidear-empty-cart-div">';
    cartDetails += '<img class="sidear-empty-cart-img" src="./assets/svg/empty_cart.svg" alt="">';
    cartDetails += '<h4>Your Cart is Empty</h4>';
    cartDetails += '</div>';
}

    cartHTML += '<div class="sidebar-footer">';
    cartHTML += '<span class="cart-total">';
    cartHTML += `Total Price: ${totalPrice}`;
    cartHTML += '</span>';
    cartHTML += '<button class="sidebar-checkout-button" onclick="checkOut()">Check out</button>'
    cartHTML += '</div>';

    document.getElementsByClassName("sidebar")[0].innerHTML = cartHTML;
}

// Load cart data on window load
window.addEventListener('load', initialize());
