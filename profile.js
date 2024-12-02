document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('card-toggle');
    const socialCard = document.getElementById('card-social');

    let isOpen = false;

    toggleButton.addEventListener('click', () => {
        if (!isOpen) {
            socialCard.classList.add('animation');
            socialCard.classList.remove('down-animation');
            isOpen = true;
        } else {
            socialCard.classList.remove('animation');
            socialCard.classList.add('down-animation');
            isOpen = false;
        }
    });

    socialCard.addEventListener('animationend', (event) => {
        if (event.animationName === 'down-animation') {
            socialCard.classList.remove('down-animation');
        } else if (event.animationName === 'up-animation') {
        }
    });

    const logoutModal = document.getElementById("logoutModal");
    const powerOffIcon = document.querySelector(".card__social-link:last-child");
    const modalClose = document.getElementById("modalClose");
    const confirmLogout = document.getElementById("confirmLogout");
    const cancelLogout = document.getElementById("cancelLogout");

    powerOffIcon.addEventListener("click", (event) => {
        event.preventDefault();
        logoutModal.style.display = "block";
    });

    modalClose.addEventListener("click", () => {
        logoutModal.style.display = "none";
    });

    cancelLogout.addEventListener("click", () => {
        logoutModal.style.display = "none";
    });

    confirmLogout.addEventListener("click", () => {
        window.location.href = "logout.php";
    });

    window.addEventListener("click", (event) => {
        if (event.target === logoutModal) {
            logoutModal.style.display = "none";
        }
    });
});

