
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate__animated', 'animate__fadeIn');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.card, .user-profile').forEach(element => {
    observer.observe(element);
});

const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
sidebarLinks.forEach(link => {
    link.addEventListener('mouseenter', () => {
        link.querySelector('i').classList.add('animate__animated', 'animate__rubberBand');
    });
    link.addEventListener('mouseleave', () => {
        link.querySelector('i').classList.remove('animate__animated', 'animate__rubberBand');
    });
});

const newPasswordInput = document.getElementById('new_password');
const passwordStrengthMeter = document.querySelector('.password-strength-meter div');
const passwordStrengthText = document.querySelector('.password-strength-text');

newPasswordInput.addEventListener('input', updatePasswordStrength);

function updatePasswordStrength() {
    const password = newPasswordInput.value;
    const strength = calculatePasswordStrength(password);
    
    passwordStrengthMeter.style.width = `${strength}%`;
    passwordStrengthMeter.style.backgroundColor = getColorForStrength(strength);
    passwordStrengthText.textContent = getTextForStrength(strength);
}

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length > 6) strength += 20;
    if (password.length > 10) strength += 20;
    if (/[A-Z]/.test(password)) strength += 20;
    if (/[0-9]/.test(password)) strength += 20;
    if (/[^A-Za-z0-9]/.test(password)) strength += 20;
    return strength;
}

function getColorForStrength(strength) {
    if (strength < 40) return '#ff4d4d';
    if (strength < 70) return '#ffa64d';
    return '#4dff4d';
}

function getTextForStrength(strength) {
    if (strength < 40) return 'Weak';
    if (strength < 70) return 'Moderate';
    return 'Strong';
}
