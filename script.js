document.addEventListener("DOMContentLoaded", function() {
    // Highlight the current active page in navigation
    highlightCurrentPage();
    
    // Initialize gallery filtering if on gallery page
    if (document.querySelector('.gallery-categories')) {
        initGalleryFilters();
    }
    
    // Initialize form validation if on contact page
    if (document.querySelector('.contact-form form')) {
        initFormValidation();
    }
    
    // Initialize image modals if on gallery page
    if (document.querySelector('.gallery-grid')) {
        initImageModals();
    }
    
    // Initialize blog search if on blog page
    if (document.querySelector('.blog-posts')) {
        initBlogSearch();
    }
});

// Function to highlight the current page in navigation
function highlightCurrentPage() {
    const currentPage = window.location.pathname.split('/').pop();
    
    const navLinks = document.querySelectorAll('nav ul li a');
    navLinks.forEach(link => {
        // Remove active class from all links
        link.classList.remove('active');
        
        // Add active class to current page link
        const linkHref = link.getAttribute('href');
        if (linkHref === currentPage || 
            (currentPage === '' && linkHref === 'index.html')) {
            link.classList.add('active');
        }
    });
}

// Function to initialize gallery filtering
function initGalleryFilters() {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get category to filter by
            const filterCategory = this.textContent.toLowerCase();
            
            // Show/hide gallery items based on category
            galleryItems.forEach(item => {
                const caption = item.querySelector('.gallery-caption h3').textContent;
                
                if (filterCategory === 'all') {
                    item.style.display = 'block';
                } else {
                    // Check if item caption or category contains filter word
                    if (caption.toLowerCase().includes(filterCategory)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
}

// Function to initialize form validation
function initFormValidation() {
    const form = document.querySelector('.contact-form form');
    
    form.addEventListener('submit', function(event) {
        let valid = true;
        
        // Get all required inputs
        const requiredInputs = form.querySelectorAll('[required]');
        
        requiredInputs.forEach(input => {
            // Remove any existing error messages
            const existingError = input.parentElement.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            
            // Validate email format
            if (input.type === 'email' && input.value.trim() !== '') {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(input.value.trim())) {
                    valid = false;
                    displayError(input, 'Please enter a valid email address');
                }
            }
            
            // Check if input is empty
            if (input.value.trim() === '') {
                valid = false;
                displayError(input, 'This field is required');
            }
        });
        
        // If form is not valid, prevent submission
        if (!valid) {
            event.preventDefault();
        } else {
            // Show success message (in a real application, you'd handle the form submission)
            event.preventDefault(); // Remove this in a real application
            showSubmitMessage('Message sent successfully! I will get back to you soon.');
        }
    });
    
    // Function to display error message
    function displayError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = '#ff3860';
        errorDiv.style.fontSize = '0.8rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        
        input.style.borderColor = '#ff3860';
        input.parentElement.appendChild(errorDiv);
        
        // Remove error when input is focused
        input.addEventListener('input', function() {
            const error = this.parentElement.querySelector('.error-message');
            if (error) {
                error.remove();
                this.style.borderColor = '#ddd';
            }
        });
    }
    
    // Function to display submit message
    function showSubmitMessage(message) {
        // Clear the form
        form.reset();
        
        // Create success message
        const messageDiv = document.createElement('div');
        messageDiv.className = 'submit-message';
        messageDiv.style.backgroundColor = '#48c774';
        messageDiv.style.color = 'white';
        messageDiv.style.padding = '1rem';
        messageDiv.style.borderRadius = '4px';
        messageDiv.style.marginTop = '1rem';
        messageDiv.textContent = message;
        
        // Insert message after form
        form.parentElement.appendChild(messageDiv);
        
        // Remove message after 5 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
}

// Function to initialize image modals
function initImageModals() {
    // Create modal container
    const modalContainer = document.createElement('div');
    modalContainer.className = 'modal-container';
    modalContainer.style.display = 'none';
    modalContainer.style.position = 'fixed';
    modalContainer.style.zIndex = '1000';
    modalContainer.style.left = '0';
    modalContainer.style.top = '0';
    modalContainer.style.width = '100%';
    modalContainer.style.height = '100%';
    modalContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    modalContainer.style.justifyContent = 'center';
    modalContainer.style.alignItems = 'center';
    
    // Create modal content
    const modalContent = document.createElement('div');
    modalContent.className = 'modal-content';
    modalContent.style.maxWidth = '80%';
    modalContent.style.maxHeight = '80%';
    modalContent.style.position = 'relative';
    
    // Create modal image
    const modalImage = document.createElement('img');
    modalImage.className = 'modal-image';
    modalImage.style.maxWidth = '100%';
    modalImage.style.maxHeight = '80vh';
    modalImage.style.display = 'block';
    modalImage.style.margin = '0 auto';
    modalImage.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
    
    // Create caption
    const modalCaption = document.createElement('div');
    modalCaption.className = 'modal-caption';
    modalCaption.style.textAlign = 'center';
    modalCaption.style.padding = '1rem';
    modalCaption.style.color = 'white';
    modalCaption.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    modalCaption.style.width = '100%';
    
    // Create close button
    const closeButton = document.createElement('span');
    closeButton.innerHTML = '&times;';
    closeButton.className = 'modal-close';
    closeButton.style.position = 'absolute';
    closeButton.style.top = '10px';
    closeButton.style.right = '15px';
    closeButton.style.color = 'white';
    closeButton.style.fontSize = '35px';
    closeButton.style.fontWeight = 'bold';
    closeButton.style.cursor = 'pointer';
    
    // Append elements
    modalContent.appendChild(modalImage);
    modalContent.appendChild(modalCaption);
    modalContent.appendChild(closeButton);
    modalContainer.appendChild(modalContent);
    document.body.appendChild(modalContainer);
    
    // Add click event to gallery items
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', function() {
            const imgSrc = this.querySelector('img').src;
            const title = this.querySelector('.gallery-caption h3').textContent;
            const desc = this.querySelector('.gallery-caption p').textContent;
            
            modalImage.src = imgSrc;
            modalCaption.innerHTML = `<h3>${title}</h3><p>${desc}</p>`;
            modalContainer.style.display = 'flex';
            
            // Disable scrolling on body
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when clicking close button
    closeButton.addEventListener('click', function() {
        modalContainer.style.display = 'none';
        document.body.style.overflow = '';
    });
    
    // Close modal when clicking outside image
    modalContainer.addEventListener('click', function(event) {
        if (event.target === modalContainer) {
            modalContainer.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modalContainer.style.display === 'flex') {
            modalContainer.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
}

// Function to initialize blog search
function initBlogSearch() {
    // Create search container
    const searchContainer = document.createElement('div');
    searchContainer.className = 'blog-search';
    searchContainer.style.marginBottom = '2rem';
    searchContainer.style.display = 'flex';
    searchContainer.style.justifyContent = 'center';
    
    // Create search input
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search blog posts...';
    searchInput.className = 'search-input';
    searchInput.style.padding = '0.8rem';
    searchInput.style.border = '1px solid #ddd';
    searchInput.style.borderRadius = '4px';
    searchInput.style.width = '100%';
    searchInput.style.maxWidth = '500px';
    searchInput.style.fontSize = '1rem';
    searchInput.style.transition = 'border-color 0.3s';
    
    // Add focus style
    searchInput.addEventListener('focus', function() {
        this.style.borderColor = '#6e8efb';
        this.style.outline = 'none';
    });
    
    searchInput.addEventListener('blur', function() {
        this.style.borderColor = '#ddd';
    });
    
    // Add search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const blogPosts = document.querySelectorAll('.blog-post');
        
        blogPosts.forEach(post => {
            const title = post.querySelector('h3').textContent.toLowerCase();
            const content = post.querySelector('.blog-post-excerpt').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                post.style.display = 'block';
            } else {
                post.style.display = 'none';
            }
        });
    });
    
    // Add search input to container
    searchContainer.appendChild(searchInput);
    
    // Insert search container after blog-intro section
    const blogIntro = document.querySelector('.blog-intro');
    blogIntro.parentNode.insertBefore(searchContainer, blogIntro.nextSibling);
}

// Add smooth scrolling for better user experience
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Add after the DOMContentLoaded event listener
// Dark mode toggle functionality
function initDarkModeToggle() {
    // Create toggle container
    const toggleContainer = document.createElement('div');
    toggleContainer.className = 'dark-mode-toggle';
    toggleContainer.style.position = 'fixed';
    toggleContainer.style.bottom = '20px';
    toggleContainer.style.right = '20px';
    toggleContainer.style.zIndex = '999';
    toggleContainer.style.backgroundColor = '#6e8efb';
    toggleContainer.style.color = 'white';
    toggleContainer.style.width = '50px';
    toggleContainer.style.height = '50px';
    toggleContainer.style.borderRadius = '50%';
    toggleContainer.style.display = 'flex';
    toggleContainer.style.justifyContent = 'center';
    toggleContainer.style.alignItems = 'center';
    toggleContainer.style.cursor = 'pointer';
    toggleContainer.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.2)';
    toggleContainer.style.transition = 'background-color 0.3s';
    
    // Create moon/sun icon
    const icon = document.createElement('div');
    icon.innerHTML = '🌙'; // Moon icon for light mode
    icon.style.fontSize = '1.5rem';
    
    toggleContainer.appendChild(icon);
    document.body.appendChild(toggleContainer);
    
    // Check for saved preference
    const darkMode = localStorage.getItem('darkMode') === 'true';
    if (darkMode) {
        enableDarkMode();
    }
    
    // Toggle dark mode on click
    toggleContainer.addEventListener('click', function() {
        if (document.body.classList.contains('dark-mode')) {
            disableDarkMode();
        } else {
            enableDarkMode();
        }
    });
    
    function enableDarkMode() {
        document.body.classList.add('dark-mode');
        icon.innerHTML = '☀️'; // Sun icon for dark mode
        localStorage.setItem('darkMode', 'true');
        
        // Apply dark mode styles
        document.body.style.backgroundColor = '#1a1a1a';
        document.body.style.color = '#f5f5f5';
        
        // Adjust feature cards
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach(card => {
            card.style.backgroundColor = '#2d2d2d';
            card.style.color = '#f5f5f5';
        });
        
        // Adjust blog posts
        const blogPosts = document.querySelectorAll('.blog-post, .sidebar-widget');
        blogPosts.forEach(post => {
            post.style.backgroundColor = '#2d2d2d';
            post.style.color = '#f5f5f5';
        });
        
        // Adjust contact form and info
        const contactSections = document.querySelectorAll('.contact-form, .contact-info');
        contactSections.forEach(section => {
            section.style.backgroundColor = '#2d2d2d';
            section.style.color = '#f5f5f5';
        });
    }
    
    function disableDarkMode() {
        document.body.classList.remove('dark-mode');
        icon.innerHTML = '🌙'; // Moon icon for light mode
        localStorage.setItem('darkMode', 'false');
        
        // Remove dark mode styles
        document.body.style.backgroundColor = '';
        document.body.style.color = '';
        
        // Reset feature cards
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach(card => {
            card.style.backgroundColor = '';
            card.style.color = '';
        });
        
        // Reset blog posts
        const blogPosts = document.querySelectorAll('.blog-post, .sidebar-widget');
        blogPosts.forEach(post => {
            post.style.backgroundColor = '';
            post.style.color = '';
        });
        
        // Reset contact form and info
        const contactSections = document.querySelectorAll('.contact-form, .contact-info');
        contactSections.forEach(section => {
            section.style.backgroundColor = '';
            section.style.color = '';
        });
    }
}

// Call the dark mode toggle function inside the DOMContentLoaded event
document.addEventListener("DOMContentLoaded", function() {
    // Existing functions
    highlightCurrentPage();
    
    if (document.querySelector('.gallery-categories')) {
        initGalleryFilters();
    }
    
    if (document.querySelector('.contact-form form')) {
        initFormValidation();
    }
    
    if (document.querySelector('.gallery-grid')) {
        initImageModals();
    }
    
    if (document.querySelector('.blog-posts')) {
        initBlogSearch();
    }
    
    // Initialize the dark mode toggle
    initDarkModeToggle();
    
    // Initialize smooth scrolling
    initSmoothScrolling();
});