// Rutas PHP
const API_LIST = 'clientes-lista.php';
const API_CREATE = 'clientes-crear.php';
const API_UPDATE = 'clientes-actualizar.php';
const API_DELETE = 'clientes-eliminar.php';

// Elementos
const cardsContainer = document.getElementById('cardsContainer');
const tableBody = document.querySelector('#tableList tbody');
const modal = document.getElementById('modalForm');
const modalTitle = document.getElementById('modalTitle');
const fName = document.getElementById('fName');
const fEmail = document.getElementById('fEmail');
const fPhone = document.getElementById('fPhone');
const fAddress = document.getElementById('fAddress');
const btnAdd = document.getElementById('btnAdd');
const btnCancel = document.getElementById('btnCancel');
const btnSave = document.getElementById('btnSave');
const btnSalir = document.getElementById('btnSalir');

let editingId = null;
let currentData = [];

// Cargar datos
async function loadData() {
  try {
    const res = await fetch(API_LIST);
    const json = await res.json();
    if(json.success) {
      currentData = json.data;
      renderCards(currentData);
      renderTable(currentData);
    } else alert('Error al cargar: ' + (json.error || ''));
  } catch (e) {
    console.error(e);
    alert('Error en la conexión con el servidor.');
  }
}

function renderCards(items) {
  cardsContainer.innerHTML = `
    <div class="card"><h3>Total Clientes</h3><p>${items.length}</p></div>
  `;
}

function renderTable(items) {
  tableBody.innerHTML = '';
  items.forEach(item => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${escapeHtml(item.nombre)}</td>
      <td>${escapeHtml(item.email)}</td>
      <td>${escapeHtml(item.telefono)}</td>
      <td>${escapeHtml(item.direccion)}</td>
      <td>
        <button class="btn secondary" onclick="onEdit(${item.id})">Editar</button>
        <button class="btn danger" onclick="onDelete(${item.id})">Eliminar</button>
      </td>
    `;
    tableBody.appendChild(tr);
  });
}

function openModal(mode='add', item=null) {
  modal.classList.add('open');
  if(mode === 'add') {
    modalTitle.textContent = 'Agregar Cliente';
    editingId = null;
    fName.value = '';
    fEmail.value = '';
    fPhone.value = '';
    fAddress.value = '';
  } else {
    modalTitle.textContent = 'Editar Cliente';
    editingId = item.id;
    fName.value = item.nombre;
    fEmail.value = item.email;
    fPhone.value = item.telefono;
    fAddress.value = item.direccion;
  }
}
function closeModal() { modal.classList.remove('open'); }

btnAdd.addEventListener('click', () => openModal('add'));
btnCancel.addEventListener('click', closeModal);

btnSave.addEventListener('click', async () => {
  const payload = {
    nombre: fName.value.trim(),
    email: fEmail.value.trim(),
    telefono: fPhone.value.trim(),
    direccion: fAddress.value.trim()
  };
  if(!payload.nombre || !payload.email) { alert('Nombre y correo son obligatorios'); return; }

  try {
    let res, json;
    if(editingId) {
      payload.id = editingId;
      res = await fetch(API_UPDATE, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
    } else {
      res = await fetch(API_CREATE, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
    }
    json = await res.json();
    if(json.success) {
      await loadData();
      closeModal();
    } else alert('Error: ' + (json.error || ''));
  } catch(e) {
    console.error(e);
    alert('Error guardando datos.');
  }
});

window.onEdit = (id) => {
  const item = currentData.find(i => i.id == id);
  if(item) openModal('edit', item);
};

window.onDelete = async (id) => {
  if(!confirm('¿Eliminar cliente?')) return;
  try {
    const res = await fetch(API_DELETE, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id })
    });
    const json = await res.json();
    if(json.success) await loadData();
    else alert('Error: ' + (json.error || ''));
  } catch (e) {
    console.error(e);
    alert('Error al eliminar.');
  }
};

btnSalir.addEventListener('click', () => {
  if(confirm("¿Deseas salir del sistema?")) window.location.href = "login.php";
});

function escapeHtml(text) {
  return String(text).replace(/[&<>"']/g, function(m) {
    return { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;' }[m];
  });
}

// Inicio
loadData();
