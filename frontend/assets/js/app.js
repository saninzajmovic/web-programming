let currentPage = '';
let isLoading = false; // Add this to prevent infinite loops

async function loadPage(page) {
    // Prevent recursive calls
    if (isLoading) {
        console.log('Page loading already in progress, skipping:', page);
        return;
    }
    
    console.log('🚀 Starting to load page:', page); // Debug log
    
    isLoading = true;
    const app = document.getElementById('app');
    app.innerHTML = '';
    currentPage = page;

    try {
        // Load page content FIRST
        console.log('📄 Fetching page content from:', `pages/${page}`); // Debug log
        const response = await fetch(`pages/${page}`);
        
        if (!response.ok) {
            console.error('❌ Page fetch failed:', response.status, response.statusText); // Debug log
            throw new Error(`Page not found: ${response.status} ${response.statusText}`);
        }
        
        console.log('✅ Page content fetched successfully'); // Debug log
        const htmlContent = await response.text();
        console.log('📝 Page content length:', htmlContent.length); // Debug log
        
        app.innerHTML = htmlContent;
        console.log('🏗️ Page content inserted into DOM'); // Debug log

        // Then initialize components
        console.log('⚙️ Starting page initialization...'); // Debug log
        await initPage();
        console.log('✅ Page initialization completed'); // Debug log
        
        // Update title
        document.title = `Trackify - ${page.replace('.html', '')}`;

    } catch (error) {
        console.error('💥 Load error details:', error); // Enhanced debug log
        console.error('💥 Error message:', error.message); // Debug log
        console.error('💥 Current page was:', currentPage); // Debug log
        console.error('💥 Trying to load:', page); // Debug log
        
        // IMPROVED ERROR HANDLING: Only redirect to login for authentication-related errors
        // Don't redirect if we're already on login or register pages
        if (page !== 'login.html' && page !== 'register.html' && 
            currentPage !== 'login.html' && currentPage !== 'register.html') {
            
            // Check if it's a 404 error (page not found) vs authentication error
            if (error.message.includes('404') || error.message.includes('Page not found')) {
                console.log('⚠️ Page not found, staying on current page or redirecting to dashboard');
                app.innerHTML = `
                    <div class="container mt-5">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Page Not Found!</h4>
                            <p>The requested page could not be found.</p>
                            <hr>
                            <button class="btn btn-primary" onclick="loadPage('dashboard.html')">Go to Dashboard</button>
                            <button class="btn btn-secondary" onclick="loadPage('login.html')">Go to Login</button>
                        </div>
                    </div>
                `;
            } else {
                console.log('🔄 Non-404 error, redirecting to login'); // Debug log
                isLoading = false; // Reset flag before recursive call
                loadPage('login.html');
                return;
            }
        } else {
            console.log('⚠️ Error occurred on auth page, showing error message'); // Debug log
            app.innerHTML = `
                <div class="container mt-5">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Error Loading Page!</h4>
                        <p>${error.message}</p>
                        <hr>
                        <button class="btn btn-primary" onclick="loadPage('login.html')">Go to Login</button>
                    </div>
                </div>
            `;
        }
    } finally {
        isLoading = false; // Always reset the flag
        console.log('🏁 Load page process finished for:', page); // Debug log
    }

    async function initPage() {
        // Load login scripts
        if (currentPage === 'login.html') {
            await loadScript('../utils/constants.js');
            if (typeof Constants === 'undefined') {
                console.error('Constants not loaded..');
                return;
            }
            await loadScript('../services/user-services.js');
            if (window.UserService) {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    UserService.init();
                }, 100);
            }
        }
        
        // Load register scripts (similar to login, no navbar needed)
        else if (currentPage === 'register.html') {
            await loadScript('../utils/constants.js');
            if (typeof Constants === 'undefined') {
                console.error('Constants not loaded..');
                return;
            }
            await loadScript('../services/user-services.js');
            if (window.UserService) {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    UserService.init();
                }, 100);
            }
        }

        // Load navbar for dashboard and other pages (not login or register)
        else if (currentPage !== 'login.html' && currentPage !== 'register.html') {
            console.log('Loading scripts for protected page...'); // Debug
            
            // Always try to load all required scripts (the loadScript function will skip if already loaded)
            await loadScript('../utils/constants.js');
            await loadScript('../utils/utils.js');
            await loadScript('../services/user-services.js');
            
            // Wait a moment for scripts to execute
            await new Promise(resolve => setTimeout(resolve, 50));
            
            console.log('Scripts loaded, checking if services are available...'); // Debug
            console.log('UserService available:', !!window.UserService); // Debug
            console.log('Utils available:', !!window.Utils); // Debug
            console.log('Constants available:', !!window.Constants); // Debug
            
            // Generate dynamic navbar - only check for UserService since that's what generates the navbar
            if (window.UserService) {
                console.log('Calling generateNavbar...'); // Debug
                // Add a small delay to ensure DOM is ready
                setTimeout(() => {
                    UserService.generateNavbar();
                }, 100);
            } else {
                console.error('UserService not available!'); // Debug
            }
        }

        // Initialize MDB components
        if (!window.mdb) {
            await loadScript('https://cdn.jsdelivr.net/npm/mdb-ui-kit@6.2.0/js/mdb.min.js');
        }

        // Add retry logic
        const initMDB = () => {
            if (window.mdb?.Input?.init) {
                mdb.Input.init(document.querySelectorAll('.form-outline'));
                mdb.Ripple.init(document.querySelectorAll('[data-mdb-ripple-init]'));
            } else {
                setTimeout(initMDB, 100);
            }
        };
        setTimeout(initMDB, 100);
    }
    
    function loadScript(src) {
        return new Promise((resolve, reject) => {
            // Normalize the src path
            const normalizedSrc = `/web-programming/frontend/${src.replace(/^\.\.\//, '')}`;
            
            // Check if the script content is already available in the global scope
            if (src.includes('constants.js') && typeof Constants !== 'undefined') {
                console.log(`Constants already loaded, skipping: ${normalizedSrc}`);
                setTimeout(resolve, 0);
                return;
            }
            
            if (src.includes('utils.js') && typeof Utils !== 'undefined') {
                console.log(`Utils already loaded, skipping: ${normalizedSrc}`);
                setTimeout(resolve, 0);
                return;
            }
            
            if (src.includes('user-services.js') && typeof UserService !== 'undefined') {
                console.log(`UserService already loaded, skipping: ${normalizedSrc}`);
                setTimeout(resolve, 0);
                return;
            }
            
            // Check if already loaded (using the normalized path)
            const existingScript = Array.from(document.scripts).find(
                s => s.src.endsWith(normalizedSrc) || s.src.endsWith(src)
            );
            
            if (existingScript) {
                console.log(`Script already exists in DOM, skipping: ${normalizedSrc}`);
                // If already loaded, wait a tick to ensure execution completed
                setTimeout(resolve, 0);
                return;
            }

            console.log(`Loading new script: ${normalizedSrc}`);
            const script = document.createElement('script');
            script.src = normalizedSrc;
            
            // Add a data attribute to track loaded scripts
            script.dataset.loadedBy = 'loadScript';
            
            script.onload = () => {
                console.log(`Successfully loaded: ${normalizedSrc}`);
                resolve();
            };
            
            script.onerror = () => {
                console.error(`Failed to load: ${normalizedSrc}`);
                reject(`Failed to load: ${normalizedSrc}`);
            };
            
            document.body.appendChild(script);
        });
    }
}

// Function to set the active link
function setActiveLink(page) {
    // Remove the 'active' class from all links
    const links = document.querySelectorAll('.navbar-custom .nav-link');
    links.forEach(link => link.classList.remove('active'));

    // Add the 'active' class to the clicked link
    const activeLink = document.querySelector(`.navbar-custom .nav-link[href="#"][onclick="loadPage('${page}')"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

function createWeeklyProgressChart() {
    const ctx = document.getElementById('weeklyProgressChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Calories Burned',
                data: [500, 700, 600, 800, 900, 1000, 1200],
                backgroundColor: 'rgba(89, 201, 165, 0.5)',
                borderColor: 'rgba(89, 201, 165, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Initial page load with proper token checking
function initApp() {
    const token = localStorage.getItem("user_token");
    if (token && token !== "undefined") {
        // Check if token is valid (you might want to add token validation here)
        loadPage('dashboard.html'); // Use dashboard.html instead of index.html
    } else {
        loadPage('login.html');
    }
}

// Call this when pages load
$(document).ready(function() {
    updateNavbarForUserRole();
});

// Start the app
initApp();