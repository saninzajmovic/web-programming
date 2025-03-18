// frontend/js/app.js
function loadPage(page) {
    fetch(`pages/${page}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('app').innerHTML = html;
        });
}

// Load the default page (e.g., login)
loadPage('login.html');