// ==========================
// LOGIN
// ==========================
document.getElementById("loginForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    let formData = new FormData(e.target);

    const res = await fetch("../api/users.php?action=login", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        // ako je admin → idi na admin.html
        if (data.role === "admin") {
            window.location.href = "admin.html";
        } else {
            window.location.href = "shop.html";
        }
    } else {
        document.getElementById("loginMsg").textContent = data.message;
        document.getElementById("loginMsg").style.color = "red";
    }
});


// ==========================
// REGISTER
// ==========================
document.getElementById("registerForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    let formData = new FormData(e.target);

    const res = await fetch("../api/users.php?action=register", {
        method: "POST",
        body: formData
    });

    const data = await res.json();
    const msg = document.getElementById("registerMsg");

    msg.textContent = data.message;
    msg.style.color = data.success ? "green" : "red";
});


// ==========================
// LOGOUT
// ==========================
document.getElementById("logoutBtn")?.addEventListener("click", async () => {
    const res = await fetch("../api/users.php?action=logout");
    const data = await res.json();

    if (data.success) {
        window.location.href = "index.html";
    }
});


// ==========================
// DYNAMIC NAVBAR (role-based)
// ==========================
async function loadNavbar() {

    const nav = document.getElementById("navLinks");
    if (!nav) return;

    const res = await fetch("../api/users.php?action=session");
    const data = await res.json();

    nav.innerHTML = ""; // reset


    // NOT LOGGED IN
    if (!data.logged_in) {
        nav.innerHTML += `
            <li><a href="index.html">Početna</a></li>
            <li><a href="shop.html">Proizvodi</a></li>
            <li><a href="login.html">Prijava</a></li>
            <li><a href="register.html">Registracija</a></li>
        `;
        return;
    }

    // LOGGED IN
    nav.innerHTML += `
        <li><a href="index.html">Početna</a></li>
        <li><a href="shop.html">Proizvodi</a></li>
    `;

    // ADMIN ROLE
    if (data.role === "admin") {
        nav.innerHTML += `<li><a href="admin.html">Admin panel</a></li>`;
    }

    // LOGOUT BUTTON
    nav.innerHTML += `<li><a id="logoutBtn" href="#">Odjava</a></li>`;

    // Re-bind logout event after replacing navbar
    document.getElementById("logoutBtn")?.addEventListener("click", async () => {
        const res = await fetch("../api/users.php?action=logout");
        const out = await res.json();
        if (out.success) window.location.href = "index.html";
    });
}

// pokreni na svim stranicama gdje postoji navbar
loadNavbar();
