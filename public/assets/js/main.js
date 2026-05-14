/**
 * NBK Travel Shuttle Management System
 * Main JavaScript Utilities & AJAX Handler
 */

// Global Configuration
const API_BASE = './src/controllers/';
const SESSION_TIMEOUT = 1800000; // 30 minutes

// ============================================
// AJAX Fetch Wrapper
// ============================================

async function apiCall(endpoint, method = 'GET', data = null) {
    try {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        
        if (data && (method === 'POST' || method === 'PUT')) {
            options.body = JSON.stringify(data);
        }
        
        const response = await fetch(API_BASE + endpoint, options);
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'API Error');
        }
        
        return result;
    } catch (error) {
        console.error('API Error:', error);
        showToast('error', error.message || 'An error occurred');
        return { success: false, message: error.message };
    }
}

// ============================================
// Toast Notification System
// ============================================

function showToast(type, message, duration = 5000) {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <span>${message}</span>
        <button class="btn-close" onclick="this.parentElement.remove()">×</button>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, duration);
}

// ============================================
// Modal Management
// ============================================

class Modal {
    constructor(elementId) {
        this.element = document.getElementById(elementId);
    }
    
    show() {
        if (this.element) {
            this.element.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }
    
    hide() {
        if (this.element) {
            this.element.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }
    
    toggle() {
        if (this.element.classList.contains('show')) {
            this.hide();
        } else {
            this.show();
        }
    }
}

// ============================================
// Form Validation
// ============================================

const Validator = {
    required: (value) => {
        return value && value.trim().length > 0 ? null : 'This field is required';
    },
    
    email: (value) => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(value) ? null : 'Invalid email format';
    },
    
    phone: (value) => {
        const cleaned = value.replace(/\D/g, '');
        return cleaned.length >= 10 && cleaned.length <= 15 ? null : 'Invalid phone number';
    },
    
    minLength: (minLength) => {
        return (value) => {
            return value.length >= minLength ? null : `Minimum ${minLength} characters required`;
        };
    },
    
    maxLength: (maxLength) => {
        return (value) => {
            return value.length <= maxLength ? null : `Maximum ${maxLength} characters allowed`;
        };
    },
    
    numeric: (value) => {
        return !isNaN(value) && value > 0 ? null : 'Must be a positive number';
    },
    
    datetime: (value) => {
        const regex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
        return regex.test(value) ? null : 'Invalid datetime format (YYYY-MM-DD HH:MM:SS)';
    }
};

// Validate form
function validateForm(formId, rules) {
    const form = document.getElementById(formId);
    const errors = {};
    let isValid = true;
    
    for (const [fieldName, fieldRules] of Object.entries(rules)) {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field) continue;
        
        const value = field.value;
        
        for (const rule of fieldRules) {
            const error = rule(value);
            if (error) {
                errors[fieldName] = error;
                isValid = false;
                field.classList.add('error');
                const errorEl = field.nextElementSibling;
                if (errorEl && errorEl.classList.contains('form-error')) {
                    errorEl.textContent = error;
                }
                break;
            } else {
                field.classList.remove('error');
                const errorEl = field.nextElementSibling;
                if (errorEl && errorEl.classList.contains('form-error')) {
                    errorEl.textContent = '';
                }
            }
        }
    }
    
    return { isValid, errors };
}

// ============================================
// Sidebar Toggle
// ============================================

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
}

// ============================================
// Active Navigation Highlighting
// ============================================

function setActiveNav() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    document.querySelectorAll('.nav-item').forEach(item => {
        const href = item.getAttribute('href') || '';
        if (href.includes(currentPage) || (currentPage === '' && href.includes('index'))) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// ============================================
// Table Search/Filter
// ============================================

function filterTable(tableId, searchInputId) {
    const searchInput = document.getElementById(searchInputId);
    const table = document.getElementById(tableId);
    
    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
}

// ============================================
// Date/Time Picker
// ============================================

function initDateTimePickers() {
    const inputs = document.querySelectorAll('input[type="datetime-local"]');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            const date = new Date(this.value);
            const formatted = formatDateTime(date);
            console.log('Selected:', formatted);
        });
    });
}

function formatDateTime(date) {
    const pad = (n) => String(n).padStart(2, '0');
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} ${pad(date.getHours())}:${pad(date.getMinutes())}:00`;
}

// ============================================
// Currency Formatting
// ============================================

function formatCurrency(amount) {
    return 'R ' + parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function parseCurrency(str) {
    return parseFloat(str.replace(/[R\s,]/g, ''));
}

// ============================================
// Loading Overlay
// ============================================

class LoadingOverlay {
    static show() {
        let overlay = document.getElementById('loading-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'loading-overlay';
            overlay.className = 'loading';
            overlay.innerHTML = '<div class="spinner"></div> <span>Loading...</span>';
            overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; z-index: 9999;';
            document.body.appendChild(overlay);
        }
        overlay.style.display = 'flex';
    }
    
    static hide() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }
}

// ============================================
// Confirmation Dialog
// ============================================

function confirm(message, callback) {
    const html = `
        <div id="confirm-modal" class="modal show">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Confirmation</h3>
                    <button class="modal-close" onclick="document.getElementById('confirm-modal').remove()">×</button>
                </div>
                <p>${message}</p>
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: flex-end;">
                    <button class="btn btn-secondary" onclick="document.getElementById('confirm-modal').remove()">Cancel</button>
                    <button class="btn btn-danger" id="confirm-yes">Confirm</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', html);
    
    document.getElementById('confirm-yes').addEventListener('click', function() {
        document.getElementById('confirm-modal').remove();
        callback();
    });
}

// ============================================
// Export to CSV
// ============================================

function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    let csv = [];
    
    table.querySelectorAll('tr').forEach(row => {
        const rowData = [];
        row.querySelectorAll('td, th').forEach(cell => {
            rowData.push('"' + cell.textContent.replace(/"/g, '""') + '"');
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// ============================================
// Local Storage Helpers
// ============================================

const Storage = {
    set: (key, value) => {
        localStorage.setItem(key, JSON.stringify(value));
    },
    
    get: (key) => {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : null;
    },
    
    remove: (key) => {
        localStorage.removeItem(key);
    },
    
    clear: () => {
        localStorage.clear();
    }
};

// ============================================
// Session Monitor
// ============================================

let sessionTimeout;

function resetSessionTimeout() {
    clearTimeout(sessionTimeout);
    sessionTimeout = setTimeout(() => {
        showToast('warning', 'Session expired. Please login again.');
        window.location.href = 'login.php';
    }, SESSION_TIMEOUT);
}

document.addEventListener('mousedown', resetSessionTimeout);
document.addEventListener('keydown', resetSessionTimeout);

// ============================================
// Initialization
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    setActiveNav();
    initDateTimePickers();
    resetSessionTimeout();
    
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('show');
        }
    });
    
    // Close modal on close button
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.modal').classList.remove('show');
        });
    });
});

