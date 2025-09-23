document.addEventListener("DOMContentLoaded", () => {
  const tbody = document.querySelector("#tabla-carrito tbody");
  const totalEl = document.getElementById("total");
  const btnConfirmar = document.getElementById("btn-confirmar");

  function getCart() {
    return JSON.parse(localStorage.getItem("cart_v1")) || [];
  }

  function render() {
    const cart = getCart();
    tbody.innerHTML = "";
    let total = 0;

    cart.forEach(item => {
      const subtotal = item.price * item.qty;
      total += subtotal;

      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${item.name}</td>
        <td>${item.qty}</td>
        <td>$${item.price.toFixed(2)}</td>
        <td>$${subtotal.toFixed(2)}</td>
      `;
      tbody.appendChild(tr);
    });

    totalEl.textContent = `$${total.toFixed(2)}`;
  }

  btnConfirmar.addEventListener("click", () => {
    alert("✅ Pedido confirmado. ¡Gracias por tu compra!");
    localStorage.removeItem("cart_v1");
    window.location.href = "index.html";
  });

  render();
});
