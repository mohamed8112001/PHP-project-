
<script>
// Navbar Toggle
const mobileMenu = document.getElementById('mobile-menu');
const navMenu = document.querySelector('.nav-menu');

mobileMenu.addEventListener('click', () => {
    mobileMenu.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Dynamic Navbar Background on Scroll
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Typewriter Effect for Hero Heading
const typewriterText = "Welcome to Cafeteria!";
const typewriterElement = document.getElementById('typewriter');
let i = 0;

function typeWriter() {
    if (i < typewriterText.length) {
        typewriterElement.innerHTML += typewriterText.charAt(i);
        i++;
        setTimeout(typeWriter, 100);
    }
}

window.onload = () => {
    typeWriter();
};

// Random Color Change for CTA Button on Hover
const ctaButton = document.querySelector('.cta-button');
const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96c93d', '#ffd700'];

ctaButton.addEventListener('mouseover', () => {
    const randomColor1 = colors[Math.floor(Math.random() * colors.length)];
    const randomColor2 = colors[Math.floor(Math.random() * colors.length)];
    ctaButton.style.background = `linear-gradient(90deg, ${randomColor1}, ${randomColor2})`;
});
</script>
</body>
</html>