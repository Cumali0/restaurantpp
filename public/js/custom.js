document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("reserveBtn");
    if (btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault(); // Sayfanın yukarı kaymasını engelle

            const reservationSection = document.getElementById("reservation");
            if (reservationSection) {
                reservationSection.scrollIntoView({ behavior: "smooth" });
            }
        });
    }
});

const cards = document.querySelectorAll('.tilt-card');

cards.forEach(card => {
    card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const deltaX = (x - centerX) / centerX;
        const deltaY = (y - centerY) / centerY;

        card.style.transform = `rotateX(${-deltaY * 10}deg) rotateY(${deltaX * 10}deg)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'rotateX(0) rotateY(0)';
    });
});
