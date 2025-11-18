// Dark Mode Toggle Functionality for SnackIt

class DarkModeToggle {
    constructor() {
        this.init();
    }

    init() {
        // Create toggle button
        this.createToggleButton();
        
        // Load saved theme preference
        this.loadThemePreference();
        
        // Add event listeners
        this.addEventListeners();
        
        // Update toggle button icon
        this.updateToggleIcon();
    }

    createToggleButton() {
        // Check if button already exists
        if (document.querySelector('.theme-toggle')) {
            return;
        }

        const toggleButton = document.createElement('button');
        toggleButton.className = 'theme-toggle';
        toggleButton.setAttribute('aria-label', 'Alternar tema escuro/claro');
        toggleButton.innerHTML = '<i class="fas fa-moon"></i>';
        
        document.body.appendChild(toggleButton);
        this.toggleButton = toggleButton;
    }

    addEventListeners() {
        if (this.toggleButton) {
            this.toggleButton.addEventListener('click', () => {
                this.toggleTheme();
            });
        }

        // Listen for system theme changes
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addListener(() => {
                if (!this.hasUserPreference()) {
                    this.applySystemTheme();
                }
            });
        }
    }

    toggleTheme() {
        const currentTheme = this.getCurrentTheme();
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        this.setTheme(newTheme);
        this.saveThemePreference(newTheme);
        this.updateToggleIcon();
        
        // Add smooth transition effect
        this.addTransitionEffect();
    }

    setTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.removeAttribute('data-theme');
        }
    }

    getCurrentTheme() {
        return document.documentElement.getAttribute('data-theme') || 'light';
    }

    saveThemePreference(theme) {
        try {
            localStorage.setItem('snackit-theme', theme);
        } catch (e) {
            console.warn('Não foi possível salvar a preferência de tema:', e);
        }
    }

    loadThemePreference() {
        try {
            const savedTheme = localStorage.getItem('snackit-theme');
            
            if (savedTheme) {
                this.setTheme(savedTheme);
            } else {
                // Apply system theme if no preference is saved
                this.applySystemTheme();
            }
        } catch (e) {
            console.warn('Não foi possível carregar a preferência de tema:', e);
            this.applySystemTheme();
        }
    }

    hasUserPreference() {
        try {
            return localStorage.getItem('snackit-theme') !== null;
        } catch (e) {
            return false;
        }
    }

    applySystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.setTheme('dark');
        } else {
            this.setTheme('light');
        }
        this.updateToggleIcon();
    }

    updateToggleIcon() {
        if (!this.toggleButton) return;

        const currentTheme = this.getCurrentTheme();
        const icon = this.toggleButton.querySelector('i');
        
        if (icon) {
            if (currentTheme === 'dark') {
                icon.className = 'fas fa-sun';
                this.toggleButton.setAttribute('aria-label', 'Alternar para tema claro');
            } else {
                icon.className = 'fas fa-moon';
                this.toggleButton.setAttribute('aria-label', 'Alternar para tema escuro');
            }
        }
    }

    addTransitionEffect() {
        // Add a subtle transition effect when switching themes
        document.body.style.transition = 'background-color 0.3s ease';
        
        setTimeout(() => {
            document.body.style.transition = '';
        }, 300);
    }

    // Public method to get current theme (for external use)
    getTheme() {
        return this.getCurrentTheme();
    }

    // Public method to set theme programmatically
    setThemeManually(theme) {
        if (theme === 'dark' || theme === 'light') {
            this.setTheme(theme);
            this.saveThemePreference(theme);
            this.updateToggleIcon();
        }
    }
}

// Initialize dark mode functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Create global instance
    window.darkModeToggle = new DarkModeToggle();
});

// Also initialize if script is loaded after DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.darkModeToggle) {
            window.darkModeToggle = new DarkModeToggle();
        }
    });
} else {
    // DOM is already loaded
    if (!window.darkModeToggle) {
        window.darkModeToggle = new DarkModeToggle();
    }
}

// Export for module systems (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DarkModeToggle;
}

// Delegation: funciona para vários cards dinamicamente
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.favorite-star');
  if (!btn) return;

  btn.classList.toggle('favorited');

  // ===== opcional: salvar no localStorage para persistir =====
  const card = btn.closest('.receita-card');
  if (card && card.dataset.id) {
    const id = card.dataset.id;
    const isFav = btn.classList.contains('favorited');
    // pegar mapa atual do localStorage
    const store = JSON.parse(localStorage.getItem('receitasFavoritas') || '{}');
    if (isFav) store[id] = true;
    else delete store[id];
    localStorage.setItem('receitasFavoritas', JSON.stringify(store));
  }
});
