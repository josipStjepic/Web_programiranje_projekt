// LOGIN
document.getElementById("loginForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    let formData = new FormData(e.target);
    
    const res = await fetch("../api/users.php?action=login", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        window.location.href = "shop.html";
    } else {
        document.getElementById("loginMsg").textContent = data.message;
    }
});

// REGISTER
document.getElementById("registerForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    let formData = new FormData(e.target);

    const res = await fetch("../api/users.php?action=register", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    document.getElementById("registerMsg").textContent = data.message;
});

document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.getElementById("navLinks");

    // provjeri session
    fetch("../api/users.php?action=session")
        .then(res => res.json())
        .then(user => {
            navLinks.innerHTML = ""; // očisti trenutne linkove

            if(user.logged_in) {
                // prijavljen korisnik
                navLinks.innerHTML += `<li><a href="shop.html">Proizvodi</a></li>`;
                navLinks.innerHTML += `<li><a href="#" id="logoutBtn">Odjava</a></li>`;

                // ako je admin
                if(user.role === "admin") {
                    navLinks.innerHTML += `<li><a href="admin.html">Admin</a></li>`;
                }

                // Logout funkcionalnost
                document.getElementById("logoutBtn").addEventListener("click", e => {
                    e.preventDefault();
                    fetch("../api/users.php?action=logout")
                        .then(res => res.json())
                        .then(data => {
                            if(data.success){
                                window.location.href = "index.html";
                            }
                        });
                });
            } else {
                // neprijavljen korisnik
                navLinks.innerHTML += `<li><a href="index.html">Početna</a></li>`;
                navLinks.innerHTML += `<li><a href="shop.html">Proizvodi</a></li>`;
                navLinks.innerHTML += `<li><a href="login.html">Prijava</a></li>`;
                navLinks.innerHTML += `<li><a href="register.html">Registracija</a></li>`;
            }
        });
});
