document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const menu = document.querySelector('.menu');

    

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            menu.classList.toggle('active');
            
            // Change hamburger to X
            const spans = this.querySelectorAll('span');
            if (menu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }

    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                alert('Obrigado por se inscrever! Você receberá nossas receitas em breve.');
                this.reset();
            }
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add active class to current page in navigation
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.menu a');
    
    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (currentPage === linkPage || (currentPage === '' && linkPage === 'index.html')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Initialize image placeholders if real images aren't available
    const categoryImages = document.querySelectorAll('.category-img');
    const recipeImages = document.querySelectorAll('.recipe-img');
    
    // Set placeholder colors for category images
    const placeholderColors = [
        'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)',
        'linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)',
        'linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%)',
        'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
    ];
    
    categoryImages.forEach((img, index) => {
        // Check if background image is already set via CSS
        const computedStyle = window.getComputedStyle(img);
        const bgImage = computedStyle.getPropertyValue('background-image');
        
        if (bgImage === 'none' || bgImage.includes('url("")')) {
            img.style.background = placeholderColors[index % placeholderColors.length];
        }
    });
    
    // Set placeholder colors for recipe images
    recipeImages.forEach((img, index) => {
        const computedStyle = window.getComputedStyle(img);
        const bgImage = computedStyle.getPropertyValue('background-image');
        
        if (bgImage === 'none' || bgImage.includes('url("")')) {
            img.style.background = placeholderColors[(index + 2) % placeholderColors.length];
        }
    });
});

document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const user = document.getElementById('username').value;
  const pass = document.getElementById('password').value;

  if (user && pass) {
    alert(`Welcome, ${user}!`);
  } else {
    alert('Please fill in all fields.');
  }
});


 function showForm(formId) {
        document.querySelectorAll('.form-box').forEach(box => box.classList.remove('active'));
        document.getElementById(formId).classList.add('active');
    }

    