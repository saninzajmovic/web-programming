var UserService = {
    init: function () {
        console.log("userservice.js init");
        
        // Initialize login form if it exists
        if ($("#login-form").length > 0) {
            $("#login-form").validate({
                // TODO dodaj validaciju
                submitHandler: function (form, e) {
                    e.preventDefault();
                    var entity = Object.fromEntries(new FormData(form).entries());
                    console.log("Login attempt:", entity);
                    UserService.login(entity);
                },
            });
        }
        
        // Initialize registration form if it exists
        if ($("#register-form").length > 0) {
            $("#register-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a username",
                        minlength: "Username must be at least 3 characters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 6 characters"
                    }
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    var entity = Object.fromEntries(new FormData(form).entries());
                    console.log("Registration attempt:", entity);
                    
                    // Remove confirmPassword from the entity before sending to server
                    delete entity.confirmPassword;
                    
                    UserService.register(entity);
                },
            });
        }
    },
    
    login: function (entity) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "auth/login",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log("Login successful:", result);
                localStorage.setItem("user_token", result.data.token);
                toastr.success("Login successful!");
                loadPage('dashboard.html');
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.error("Login error:", XMLHttpRequest);
                const errorMessage = XMLHttpRequest?.responseJSON?.message || 
                                   XMLHttpRequest?.responseText || 
                                   'Invalid username or password';
                toastr.error(errorMessage);
            },
        });
    },

    register: function (entity) {
        console.log("Attempting to register user:", entity);
        
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "auth/register", // Adjust endpoint as needed
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log("Registration successful:", result);
                toastr.success("Registration successful! Please login with your credentials.");
                
                // Redirect to login page after successful registration
                setTimeout(() => {
                    loadPage('login.html');
                }, 2000); // Give user time to read the success message
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.error("Registration error:", XMLHttpRequest);
                const errorMessage = XMLHttpRequest?.responseJSON?.message || 
                                   XMLHttpRequest?.responseText || 
                                   'Registration failed. Please try again.';
                toastr.error(errorMessage);
            },
        });
    },

    logout: function () {
        localStorage.clear();
        toastr.info("You have been logged out.");
        loadPage("login.html");
    },
    
    generateNavbar: function() {
        console.log('generateNavbar called');
        
        const token = localStorage.getItem("user_token");
        
        if (!token || token === "undefined") {
            console.log('No valid token found, redirecting to login');
            loadPage("login.html");
            return;
        }

        try {
            // Simple JWT parsing - don't depend on Utils
            let user = null;
            try {
                // Basic JWT decode (for payload only, not secure validation)
                const payload = JSON.parse(atob(token.split('.')[1]));
                user = payload.user;
                console.log('User from token:', user);
            } catch (jwtError) {
                console.error('Failed to parse JWT:', jwtError);
                // If JWT parsing fails, redirect to login
                loadPage("login.html");
                return;
            }
            
            let navItems = '';

            // Base navigation items for all users
            const baseNavItems = `
                <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('profile.html')">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('goals.html')">Goals</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('workout-log.html')">Workout Log</a></li>
            `;

            // Role-specific navigation items
            if (user && user.role) {
                console.log('User role:', user.role);
                switch(user.role) {
                    case 'user':
                        navItems = baseNavItems;
                        break;
                    case 'premium':
                        navItems = baseNavItems;
                        break;
                    default:
                        navItems = baseNavItems;
                }
            } else {
                navItems = baseNavItems;
            }

            // Create premium indicator if user is premium
            const premiumIndicator = (user && user.role === 'premium') ? 
                `<span class="navbar-text premium-indicator">✨ Premium User</span>` : '';

            // Create the complete navbar HTML
            const navbarHTML = `
                <nav class="navbar navbar-expand-md mx-auto navbar-custom pt-4 pt-md-2 px-3 px-md-5">
                    <div class="container-fluid">
                        <a class="navbar-brand racing-sans-one-regular" href="#" onclick="loadPage('dashboard.html')">Trackify</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav me-auto">
                                ${navItems}
                            </ul>
                            <ul class="navbar-nav">
                                ${premiumIndicator}
                                <li class="nav-item">
                                    <button class="btn btn-outline-primary" onclick="UserService.logout()">Logout</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            `;

            // Insert navbar at the top of the app
            const app = document.getElementById('app');
            if (app) {
                console.log('Inserting navbar into app container');
                app.insertAdjacentHTML('afterbegin', navbarHTML);
                console.log('Navbar inserted successfully');
            } else {
                console.error('App container not found!');
            }

        } catch (error) {
            console.error('Error generating navbar:', error);
            // If any error occurs, redirect to login
            loadPage("login.html");
        }
    }
};