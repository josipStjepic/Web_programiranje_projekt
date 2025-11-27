async function loadProducts() {
    const res = await fetch("../api/products.php");
    const data = await res.json();

    const list = document.getElementById("productList");

    data.forEach(p => {
        const card = document.createElement("div");
        card.className = "product-card";

        card.innerHTML = `
            <img src="img/${p.image}" alt="">
            <h3>${p.name}</h3>
            <p>${p.price}€</p>
            <a href="product.html?id=${p.id}" class="btn">Detalji</a>
        `;

        list.appendChild(card);
    });
}

loadProducts();
