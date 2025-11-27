// Učitavanje proizvoda
async function loadAdminProducts() {
    const res = await fetch("../api/products.php");
    const data = await res.json();

    const container = document.getElementById("adminProductList");
    container.innerHTML = "";

    data.forEach(p => {
        const item = document.createElement("div");
        item.className = "admin-item";

        item.innerHTML = `
            <span>${p.name} – ${p.price}€</span>
            <button onclick="deleteProduct(${p.id})">Obriši</button>
        `;

        container.appendChild(item);
    });
}

// Dodavanje proizvoda
document.getElementById("addProductForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    await fetch("../api/products.php?action=create", {
        method: "POST",
        body: formData
    });

    loadAdminProducts();
});

// Brisanje proizvoda
async function deleteProduct(id) {
    await fetch(`../api/products.php?action=delete&id=${id}`);
    loadAdminProducts();
}

loadAdminProducts();
