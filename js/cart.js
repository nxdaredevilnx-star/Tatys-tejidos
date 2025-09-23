/* cart.js */
(() => {
  // helpers
  const q = sel => document.querySelector(sel);
  const qa = sel => Array.from(document.querySelectorAll(sel));

  // Formateador a pesos colombianos
  const formatCOP = n => new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    minimumFractionDigits: 0
  }).format(n);

  // Crear markup del drawer y añadirlo al body
  const drawer = document.createElement('div');
  drawer.className = 'cart-drawer';
  drawer.innerHTML = `
    <div class="cart-header">
      <h3>Tu carrito</h3>
      <button class="close-cart" title="Cerrar">✕</button>
    </div>
    <div class="cart-items"></div>
    <div class="cart-summary">
      <div class="total"><span>Subtotal</span><span class="subtotal-value">$0</span></div>
      <div class="total"><span>Envío</span><span class="shipping-value">$0</span></div>
      <div class="total"><span>Total</span><span class="total-value">$0</span></div>
      <div class="checkout-actions">
        <button class="btn secondary btn-continue">Seguir comprando</button>
        <button class="btn primary btn-checkout">Pagar</button>
      </div>
    </div>
  `;
  document.body.appendChild(drawer);

  const cartIcon = q('#cart-icon');
  const closeBtn = drawer.querySelector('.close-cart');
  const itemsContainer = drawer.querySelector('.cart-items');
  const subtotalEl = drawer.querySelector('.subtotal-value');
  const totalEl = drawer.querySelector('.total-value');
  const shippingEl = drawer.querySelector('.shipping-value');
  const btnContinue = drawer.querySelector('.btn-continue');
  const btnCheckout = drawer.querySelector('.btn-checkout');

  // Estado del carrito (array de items)
  let cart = JSON.parse(localStorage.getItem('cart_v1')) || [];

  // funciones
  function saveCart() {
    localStorage.setItem('cart_v1', JSON.stringify(cart));
  }

  // suma con reglas de envío en COP
  function calcTotals() {
    let subtotal = 0;
    for (let i = 0; i < cart.length; i++) {
      const item = cart[i];
      const price = Number(item.price);
      const qty = parseInt(item.qty, 10);
      subtotal += price * qty;
    }

    subtotal = Math.round(subtotal); // sin decimales
    let shipping = 0;

    // regla de envío
    if (subtotal > 79990) {
      shipping = 8000;
    }

    const total = subtotal + shipping;
    return { subtotal, shipping, total };
  }

  function renderCart() {
    itemsContainer.innerHTML = '';
    if (cart.length === 0) {
      itemsContainer.innerHTML = `<p style="color:#777">Aún no has agregado productos.</p>`;
    } else {
      cart.forEach((it, idx) => {
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
          <img src="${it.img}" alt="${it.name}">
          <div class="info">
            <h4>${it.name}</h4>
            <div><span class="price">${formatCOP(it.price)}</span></div>
          </div>
          <div class="qty">
            <button class="dec" data-index="${idx}">-</button>
            <span class="qnum">${it.qty}</span>
            <button class="inc" data-index="${idx}">+</button>
            <button class="remove" data-index="${idx}" title="Eliminar" style="margin-left:8px">🗑</button>
          </div>
        `;
        itemsContainer.appendChild(div);
      });
    }

    const totals = calcTotals();
    subtotalEl.textContent = formatCOP(totals.subtotal);
    shippingEl.textContent = formatCOP(totals.shipping);
    totalEl.textContent = formatCOP(totals.total);

    // listeners para + - remove
    qa('.cart-item .inc').forEach(btn => btn.onclick = e => {
      const i = Number(e.currentTarget.dataset.index);
      cart[i].qty = Number(cart[i].qty) + 1;
      saveCart(); renderCart();
    });
    qa('.cart-item .dec').forEach(btn => btn.onclick = e => {
      const i = Number(e.currentTarget.dataset.index);
      if (cart[i].qty > 1) cart[i].qty = Number(cart[i].qty) - 1;
      else cart.splice(i, 1);
      saveCart(); renderCart();
    });
    qa('.cart-item .remove').forEach(btn => btn.onclick = e => {
      const i = Number(e.currentTarget.dataset.index);
      cart.splice(i, 1);
      saveCart(); renderCart();
    });
  }

  // abrir/cerrar
  function openDrawer() {
    drawer.classList.add('open');
    renderCart();
  }
  function closeDrawer() {
    drawer.classList.remove('open');
  }

  cartIcon && cartIcon.addEventListener('click', (e) => {
    e.preventDefault();
    openDrawer();
  });
  closeBtn.addEventListener('click', closeDrawer);
  btnContinue.addEventListener('click', closeDrawer);

  // manejar botones add-to-cart
  function addProductToCart({ name, price, img }) {
    const index = cart.findIndex(it => it.name === name && it.price == price);
    if (index >= 0) {
      cart[index].qty = Number(cart[index].qty) + 1;
    } else {
      cart.push({ name: String(name), price: Math.round(price), img: img || '', qty: 1 });
    }
    saveCart();
    openDrawer();
  }

  // asignar listeners a botones existentes en la página
  function attachAddButtons() {
    qa('.cart-btn').forEach(btn => {
      btn.addEventListener('click', (ev) => {
        ev.preventDefault();
        const name = btn.dataset.name || (btn.closest('.box')?.querySelector('h3')?.innerText || 'Producto');

        let price = btn.dataset.price || btn.closest('.box')?.querySelector('.price')?.innerText || '0';
        // Quitar símbolos y espacios, respetar miles
        price = price.replace(/[^\d.,]/g, '').replace(/\./g, '');
        // Reemplazar coma decimal por punto si existe
        const priceNum = Number(price.replace(',', '.')) || 0;

        const img = btn.dataset.img || btn.closest('.box')?.querySelector('img')?.src || '';
        addProductToCart({ name, price: priceNum, img });
      });
    });
  }

  attachAddButtons();

  // Enviar carrito a checkout.php
  btnCheckout.addEventListener('click', () => {
    if (cart.length === 0) {
      alert('El carrito está vacío.');
      return;
    }
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = './php/checkout.php';
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'cart_json';
    input.value = JSON.stringify(cart);
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
  });

  // Debug
  window.__SHOP_CART = {
    get: () => JSON.parse(localStorage.getItem('cart_v1') || '[]'),
    clear: () => { cart = []; saveCart(); renderCart(); }
  };

  // Render inicial
  renderCart();

})();

