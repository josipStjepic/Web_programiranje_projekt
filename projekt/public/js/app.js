// Responzivni meni
document.getElementById("menuToggle")?.addEventListener("click", () => {
    const nav = document.getElementById("navLinks");
    nav.style.display = nav.style.display === "flex" ? "none" : "flex";
});
