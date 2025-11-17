import './bootstrap';

// Import Bootstrap JavaScript
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Import Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Language Switcher
window.switchLanguage = function(locale) {
    fetch(`/language/${locale}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => {
        window.location.reload();
    });
};

// Donation Amount Selection
window.selectAmount = function(amount) {
    const customInput = document.getElementById('custom-amount');
    const amountButtons = document.querySelectorAll('.amount-btn');

    amountButtons.forEach(btn => {
        btn.classList.remove('active');
    });

    event.target.classList.add('active');
    customInput.value = amount;
};

// Gift Donation Toggle
window.toggleGiftForm = function() {
    const giftForm = document.getElementById('gift-donation-form');
    const isGift = document.getElementById('gift-donation-checkbox').checked;

    if (isGift) {
        giftForm.style.display = 'block';
    } else {
        giftForm.style.display = 'none';
    }
};
