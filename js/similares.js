document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".add-cart");

  function saveCart(cart) {
    localStorage.setItem("cart_v1", JSON.stringify(cart));
  }

  function getCart() {
    return JSON.parse(localStorage.getItem("cart_v1")) || [];
  }

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      const name = btn.dataset.name;
      const price = parseFloat(btn.dataset.price);
      const img = btn.dataset.img;

      let cart = getCart();
      const idx = cart.findIndex(p => p.name === name);
      if (idx >= 0) {
        cart[idx].qty += 1;
      } else {
        cart.push({ name, price, img, qty: 1 });
      }
      saveCart(cart);
      alert(`${name} agregado al carrito ✅`);
    });
  });
});
