const base_url = document.getElementById("base_url").value;

function toggleTheme() {
    const html = document.documentElement;
    const icon = document.getElementById("themeIcon");

    if (html.classList.contains("dark")) {
        html.classList.remove("dark");
        icon.textContent = "dark_mode";
        localStorage.setItem("theme", "light");
    } else {
        html.classList.add("dark");
        icon.textContent = "light_mode";
        localStorage.setItem("theme", "dark");
    }
}

function togglePassword() {
    const input = document.getElementById("passwordInput");
    const icon = document.getElementById("passwordIcon");
    if (input.type === "password") {
        input.type = "text";
        icon.textContent = "visibility_off";
    } else {
        input.type = "password";
        icon.textContent = "visibility";
    }
}

function handleLogin(event) {
    event.preventDefault();
    const btn = event.submitter;
    const originalContent = btn.innerHTML;

    // Loading State
    btn.disabled = true;
    btn.innerHTML = `
                <svg class="animate-spin h-6 w-6 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;

    fetch("auth/acceder", {
        method: "POST",
        body: new FormData(event.target)
    })
        .then(response => response.json())
        .then(data => {

            if (data.status === "success") {
                window.location.href = `${base_url}dashboard`;
            } else {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                alert(data.message);
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
            alert("Error al iniciar sesión");
        });
}

// Initialize Theme from localStorage
if (
    localStorage.getItem("theme") === "dark" ||
    (!("theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    document.documentElement.classList.add("dark");
    document.getElementById("themeIcon").textContent = "light_mode";
}