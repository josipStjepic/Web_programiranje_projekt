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
