function loadPage(page) {
    // Clear the app container
    document.getElementById('app').innerHTML = '';

    fetch(`pages/${page}`)
        .then(response => response.text())
        .then(html => {
            // Load the content into the app container
            document.getElementById('app').innerHTML = html;

            // Update the title based on the page
            if (page === 'login.html') {
                document.title = "Trackify - Login";
            } else if (page === 'register.html') {
                document.title = "Trackify - Register";
            } else if (page === 'dashboard.html') {
                document.title = "Trackify - Dashboard";
            } else if (page === 'profile.html') {
                document.title = "Trackify - Profile";
            } else if (page === 'goals.html') {
                document.title = "Trackify - Goals";
            } else if (page === 'workout-log.html') {
                document.title = "Trackify - Workout Log";
            }

            // Load the navbar for dashboard, profile, and workout-log pages
            if (page === 'dashboard.html' || page === 'profile.html' || page === 'goals.html' || page === 'workout-log.html') {
                loadNavbar().then(() => {
                    // Set the active link after the navbar is loaded
                    setActiveLink(page);
                });
            }
            if (page === 'dashboard.html') {
                createWeeklyProgressChart();
            }

        })
        .catch(error => {
            console.error('Error loading page:', error);
        });
}

// Function to load the navbar
function loadNavbar() {
    return fetch('pages/nav.html')
        .then(response => response.text())
        .then(html => {
            // Insert the navbar at the top of the app container
            document.getElementById('app').insertAdjacentHTML('afterbegin', html);
        })
        .catch(error => {
            console.error('Error loading navbar:', error);
        });
}

// Function to set the active link
// frontend/js/app.js
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
// Load the default page (e.g., login)
loadPage('login.html');