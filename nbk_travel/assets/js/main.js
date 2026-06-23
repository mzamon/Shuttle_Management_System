/**
 * NBK Travel – Core JS Utilities v3.0
 */

/* ── API ─────────────────────────────────────────────────── */
async function apiCall(endpoint, method = 'GET', data = null) {
  const opts = { method, headers: { 'Content-Type': 'application/json' } };
  if (data && method !== 'GET') opts.body = JSON.stringify(data);
  try {
    const res = await fetch(endpoint, opts);
    const json = await res.json();
    return json;
  } catch (err) {
    console.error('API Error:', err);
    return { success: false, message: 'Network error. Please try again.' };
  }
}

/* ── Toast ───────────────────────────────────────────────── */
function showToast(message, type = 'info', duration = 3500) {
  let container = document.querySelector('.toast-wrap');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-wrap';
    document.body.appendChild(container);
  }
  const icons = {
    success: '<polyline points="20 6 9 17 4 12"/>',
    error:   '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
    warning: '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
    info:    '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'
  };
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `<span class="toast-icon"><svg viewBox="0 0 24 24">${icons[type]||icons.info}</svg></span><span>${message}</span>`;
  container.appendChild(toast);
  setTimeout(() => { toast.classList.add('out'); setTimeout(() => toast.remove(), 250); }, duration);
}

/* ── Debounce ────────────────────────────────────────────── */
function debounce(fn, wait) {
  let t;
  return function(...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait); };
}

/* ── Login Modal (landing page) ───────────────────────────── */
function openLoginModal() {
  const overlay = document.getElementById('loginModal');
  if (overlay) {
    overlay.classList.add('active');
    setTimeout(() => overlay.querySelector('input')?.focus(), 300);
  }
}
function closeLoginModal() {
  const overlay = document.getElementById('loginModal');
  if (overlay) overlay.classList.remove('active');
}
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeLoginModal();
});
document.addEventListener('click', e => {
  const overlay = document.getElementById('loginModal');
  if (overlay && e.target === overlay) closeLoginModal();
});

/* ── Format Helpers ──────────────────────────────────────── */
function fmtCurrency(amount) {
  return new Intl.NumberFormat('en-ZA', { style: 'currency', currency: 'ZAR', minimumFractionDigits: 2 }).format(amount);
}
function fmtDate(s) {
  return new Date(s).toLocaleDateString('en-ZA', { year: 'numeric', month: 'short', day: 'numeric' });
}

/* ── Export ──────────────────────────────────────────────── */
window.NBKTravel = { apiCall, showToast, debounce, openLoginModal, closeLoginModal, fmtCurrency, fmtDate };
