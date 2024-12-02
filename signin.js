document.getElementById('username').addEventListener('keypress', function (event) {
    if (event.key === 'Enter') {
        authenticate();
    }
});

document.getElementById('password').addEventListener('keypress', function (event) {
    if (event.key === 'Enter') {
        authenticate();
    }
});

function authenticate() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    const adminCredentials = {
        username: "admin",
        password: "admin"
    };

    const studentCredentials = {
        username: "student",
        password: "student"
    };

    if (username === adminCredentials.username && password === adminCredentials.password) {
        window.location.href = "home.html";
        return;
    }

    if (username === studentCredentials.username && password === studentCredentials.password) {
        window.location.href = "profile.html";
        return;
    }

    alert("Invalid username or password. Please try again.");
}
