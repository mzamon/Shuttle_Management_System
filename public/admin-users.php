<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Admin Users Management</h1>
                <button class="btn btn-primary" onclick="showAddUserModal()">+ New User</button>
            </div>
            
            <!-- Search -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="form-group">
                    <input type="text" id="userSearch" placeholder="Search by name, username, or email..." onkeyup="searchUsers()">
                </div>
            </div>
            
            <!-- Users Table -->
            <div class="card">
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersBody">
                        <tr><td colspan="9" class="text-center">Loading users...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <h2 id="modalTitle">Add New User</h2>
                <button class="modal-close" onclick="userModal.hide()">&times;</button>
            </div>
            
            <form id="userForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" id="firstName" name="firstName" required>
                        <span class="error-message" id="err-firstName"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" id="lastName" name="lastName" required>
                        <span class="error-message" id="err-lastName"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" id="email" name="email" required>
                        <span class="error-message" id="err-email"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber">
                        <span class="error-message" id="err-phoneNumber"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Role *</label>
                        <select id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">Administrator</option>
                            <option value="driver">Driver</option>
                            <option value="customer">Customer</option>
                        </select>
                        <span class="error-message" id="err-role"></span>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                        <p style="margin: 0; font-size: 0.9rem; color: rgba(255,255,255,0.7);">
                            <strong>Note:</strong> Username and temporary password will be auto-generated:
                        </p>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                            Username: firstname.lastname (lowercase)<br>
                            Password: Will be shown once and must be changed on first login
                        </p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="userModal.hide()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <h2>Edit User</h2>
                <button class="modal-close" onclick="editUserModalObj.hide()">&times;</button>
            </div>
            
            <form id="editUserForm">
                <div class="modal-body">
                    <input type="hidden" id="editUserId">
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="editUsername" disabled style="opacity: 0.6;">
                    </div>
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="editFullName">
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="editEmail">
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" id="editPhoneNumber">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select id="editStatus">
                            <option value="ACTIVE">Active</option>
                            <option value="INACTIVE">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Role</label>
                        <select id="editRole">
                            <option value="admin">Administrator</option>
                            <option value="driver">Driver</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="editUserModalObj.hide()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Credentials Display Modal -->
    <div id="credentialsModal" class="modal">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <h2>New User Created Successfully</h2>
                <button class="modal-close" onclick="credentialsModalObj.hide()">&times;</button>
            </div>
            
            <div class="modal-body">
                <div style="background: rgba(255, 193, 7, 0.2); border: 1px solid rgba(255, 193, 7, 0.5); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    <p style="margin: 0; color: #ffc107; font-weight: bold;">⚠ Important: Save these credentials now!</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: rgba(255, 193, 7, 0.9);">These will only be displayed once.</p>
                </div>
                
                <div style="background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-family: monospace;">
                    <p style="margin: 0; color: rgba(255,255,255,0.7);">
                        <strong>Username:</strong><br>
                        <span id="cred-username" style="color: #fff; font-weight: bold;"></span>
                    </p>
                    <p style="margin: 1rem 0 0 0; color: rgba(255,255,255,0.7);">
                        <strong>Temporary Password:</strong><br>
                        <span id="cred-password" style="color: #fff; font-weight: bold;"></span>
                    </p>
                    <p style="margin: 1rem 0 0 0; font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                        User must change password on first login.
                    </p>
                </div>
                
                <div style="background: rgba(33, 150, 243, 0.1); padding: 1rem; border-radius: 0.5rem;">
                    <p style="margin: 0; font-size: 0.9rem;">
                        <strong>Next Steps:</strong><br>
                        1. Share credentials securely with the user<br>
                        2. User logs in with username/password<br>
                        3. User is forced to change password on first login
                    </p>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="copyCredentials()">Copy to Clipboard</button>
                <button type="button" class="btn btn-primary" onclick="credentialsModalObj.hide()">Done</button>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        const userModal = new Modal('addUserModal');
        const editUserModalObj = new Modal('editUserModal');
        const credentialsModalObj = new Modal('credentialsModal');
        let currentCredentials = {};
        
        async function loadUsers() {
            const result = await apiCall('login.php?action=list', 'GET');
            
            const tbody = document.getElementById('usersBody');
            tbody.innerHTML = '';
            
            if (result.success && result.data) {
                result.data.forEach(user => {
                    const statusBadge = `<span class="badge ${user.status === 'ACTIVE' ? 'badge-success' : 'badge-danger'}">${user.status}</span>`;
                    const row = `
                        <tr>
                            <td>${user.username}</td>
                            <td>${user.firstName} ${user.lastName}</td>
                            <td>${user.email}</td>
                            <td><span class="badge badge-info">${user.role}</span></td>
                            <td>${user.phoneNumber || '-'}</td>
                            <td>${statusBadge}</td>
                            <td>${user.lastLoginAt ? new Date(user.lastLoginAt).toLocaleString() : 'Never'}</td>
                            <td>${new Date(user.createdAt).toLocaleDateString()}</td>
                            <td>
                                <button class="btn btn-small btn-primary" onclick="editUser(${user.userId})">Edit</button>
                                <button class="btn btn-small btn-danger" onclick="if(confirm('Delete this user?')) deleteUser(${user.userId})">Delete</button>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center">No users found</td></tr>';
            }
        }
        
        function showAddUserModal() {
            document.getElementById('userForm').reset();
            document.getElementById('modalTitle').textContent = 'Add New User';
            userModal.show();
        }
        
        function generateUsername(firstName, lastName) {
            return `${firstName.toLowerCase()}.${lastName.toLowerCase()}`;
        }
        
        function generatePassword() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }
        
        document.getElementById('userForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phoneNumber').value.trim();
            const role = document.getElementById('role').value;
            
            // Validation
            if (!firstName || !lastName || !email || !role) {
                showToast('error', 'Please fill all required fields');
                return;
            }
            
            const username = generateUsername(firstName, lastName);
            const tempPassword = generatePassword();
            
            // For demo, simulate user creation
            currentCredentials = { username, tempPassword };
            
            showToast('success', 'User created successfully');
            userModal.hide();
            
            document.getElementById('cred-username').textContent = username;
            document.getElementById('cred-password').textContent = tempPassword;
            credentialsModalObj.show();
            
            loadUsers();
        });
        
        function editUser(userId) {
            // For demo
            showToast('info', 'Edit functionality available in full deployment');
        }
        
        function deleteUser(userId) {
            // For demo
            showToast('success', 'User deleted');
            loadUsers();
        }
        
        function searchUsers() {
            const query = document.getElementById('userSearch').value.toLowerCase();
            document.getElementById('usersTable').querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        }
        
        function copyCredentials() {
            const text = `Username: ${currentCredentials.username}\nPassword: ${currentCredentials.tempPassword}`;
            navigator.clipboard.writeText(text).then(() => {
                showToast('success', 'Credentials copied to clipboard');
            });
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            loadUsers();
        });
    </script>
</body>
</html>
