const sideMenu = document.querySelector('aside');
const menuBtn = document.querySelector('#menu-btn');
const closeBtn = document.querySelector('#close-btn');
const themeToggle = document.querySelector('.theme-toggler');

// Menü aç/kapat
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

// Dark/Light toggle
themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');
    themeToggle.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggle.querySelector('span:nth-child(2)').classList.toggle('active');
});


document.addEventListener('DOMContentLoaded', function () {
    const logoutLink = document.getElementById('logout-link');
    logoutLink.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('logout-form').submit();
    });
});



/*
Orders.forEach(reservation => {

    const tr = document.createElement('tr');
    const trContent = `
        <td>${reservation.reservationName}</td>
        <td>${reservation.tableNumber}</td>
        <td>${reservation.paymentStatus}</td>
        <td class="${
        reservation.orderStatus === 'Pending' ? 'warning' :
            reservation.orderStatus === 'Preparing' ? 'primary' :
                reservation.orderStatus === 'Served' ? 'success' :
                    reservation.orderStatus === 'Completed' ? 'completed' : ''
    }">${reservation.orderStatus}</td>
        <td class="primary">Detaylar</td>
    `;
    tr.innerHTML = trContent;
    document.querySelector('table tbody').appendChild(tr);
});

*/
