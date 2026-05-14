/**
 * Global JavaScript Utilities
 * NBK Travel Shuttle Booking Management System
 */

// API Base URL
const API_BASE = '/api';

/**
 * Fetch wrapper with JSON support
 */
async function apiCall(endpoint, method = 'GET', data = null) {
  const options = {
    method: method,
    headers: {
      'Content-Type': 'application/json',
    }
  };

  if (data && method !== 'GET') {
    options.body = JSON.stringify(data);
  }

  try {
    const response = await fetch(endpoint, options);
    const result = await response.json();
    return result;
  } catch (error) {
    console.error('API Error:', error);
    return { success: false, message: 'Network error. Please try again.' };
  }
}

/**
 * Show notification toast
 */
function showToast(message, type = 'info', duration = 3000) {
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.textContent = message;
  toast.style.cssText = `
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 16px 24px;
    background: ${getToastColor(type)};
    color: white;
    border-radius: 8px;
    z-index: 9999;
    animation: slideIn 0.3s ease;
  `;

  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), duration);
}

function getToastColor(type) {
  const colors = {
    success: 'rgba(46, 213, 115, 0.9)',
    error: 'rgba(255, 71, 87, 0.9)',
    warning: 'rgba(255, 165, 2, 0.9)',
    info: 'rgba(0, 212, 255, 0.9)'
  };
  return colors[type] || colors.info;
}

/**
 * Modal Management
 */
class Modal {
  constructor(modalId) {
    this.modal = document.getElementById(modalId);
    this.setupListeners();
  }

  setupListeners() {
    const closeBtn = this.modal?.querySelector('[data-close]');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.close());
    }

    this.modal?.addEventListener('click', (e) => {
      if (e.target === this.modal) {
        this.close();
      }
    });
  }

  open() {
    if (this.modal) {
      this.modal.classList.add('show');
      document.body.style.overflow = 'hidden';
    }
  }

  close() {
    if (this.modal) {
      this.modal.classList.remove('show');
      document.body.style.overflow = 'auto';
    }
  }

  toggle() {
    if (this.modal?.classList.contains('show')) {
      this.close();
    } else {
      this.open();
    }
  }
}

/**
 * Form Validation
 */
function validateForm(formId) {
  const form = document.getElementById(formId);
  if (!form) return false;

  const requiredFields = form.querySelectorAll('[required]');
  let isValid = true;

  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      field.style.borderColor = '#ff4757';
      isValid = false;
    } else {
      field.style.borderColor = '';
    }
  });

  return isValid;
}

/**
 * Format Currency
 */
function formatCurrency(amount) {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(amount);
}

/**
 * Format Date
 */
function formatDate(dateString) {
  const options = {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  };
  return new Date(dateString).toLocaleDateString('en-US', options);
}

/**
 * Format Time
 */
function formatTime(timeString) {
  const options = {
    hour: '2-digit',
    minute: '2-digit'
  };
  return new Date(timeString).toLocaleTimeString('en-US', options);
}

/**
 * Get Status Badge Class
 */
function getStatusBadgeClass(status) {
  const classList = {
    'pending': 'badge-pending',
    'confirmed': 'badge-confirmed',
    'completed': 'badge-completed',
    'cancelled': 'badge-cancelled',
    'available': 'badge-available',
    'on-trip': 'badge-on-trip',
    'off-duty': 'badge-off-duty',
    'in-use': 'badge-in-use',
    'maintenance': 'badge-maintenance'
  };
  return classList[status] || 'badge-pending';
}

/**
 * Debounce helper
 */
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Animation helper
 */
const slideIn = `
  @keyframes slideIn {
    from {
      transform: translateX(400px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
`;

// Inject animation styles
const style = document.createElement('style');
style.textContent = slideIn;
document.head.appendChild(style);

// Export for use
window.NBKTravel = {
  apiCall,
  showToast,
  Modal,
  validateForm,
  formatCurrency,
  formatDate,
  formatTime,
  getStatusBadgeClass,
  debounce
};
