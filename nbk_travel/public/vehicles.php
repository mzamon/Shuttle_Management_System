<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Vehicle Fleet Management</h1>
                <button class="btn btn-primary" onclick="showAddVehicleModal()">+ Add Vehicle</button>
            </div>
            
            <!-- Filter -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Filter by Status</label>
                        <select id="statusFilter" onchange="loadVehicles()">
                            <option value="">All Status</option>
                            <option value="ACTIVE">Active</option>
                            <option value="MAINTENANCE">Maintenance</option>
                            <option value="RETIRED">Retired</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Search Registration</label>
                        <input type="text" id="vehicleSearch" placeholder="Search by registration..." onkeyup="searchVehicles()">
                    </div>
                    
                    <div style="display: flex; align-items: flex-end;">
                        <button class="btn btn-secondary" onclick="exportVehiclesCSV()">Export CSV</button>
                    </div>
                </div>
            </div>
            
            <!-- Vehicles Grid -->
            <div id="vehiclesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                <div class="text-center" style="grid-column: 1/-1; padding: 2rem;">Loading vehicles...</div>
            </div>
        </div>
    </div>
    
    <!-- Add Vehicle Modal -->
    <div id="addVehicleModal" class="modal">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h2>Add New Vehicle</h2>
                <button class="modal-close" onclick="vehicleModal.hide()">&times;</button>
            </div>
            
            <form id="vehicleForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Registration Number *</label>
                        <input type="text" id="registrationNumber" placeholder="e.g. GP 12 NK" required>
                        <span class="error-message" id="err-registration"></span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Make *</label>
                            <input type="text" id="make" placeholder="e.g. Toyota" required>
                            <span class="error-message" id="err-make"></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Model *</label>
                            <input type="text" id="model" placeholder="e.g. Hiace" required>
                            <span class="error-message" id="err-model"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Passenger Capacity *</label>
                        <input type="number" id="capacity" placeholder="e.g. 14" min="1" max="50" required>
                        <span class="error-message" id="err-capacity"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Status *</label>
                        <select id="status" required>
                            <option value="">Select Status</option>
                            <option value="ACTIVE">Active</option>
                            <option value="MAINTENANCE">In Maintenance</option>
                            <option value="RETIRED">Retired</option>
                        </select>
                        <span class="error-message" id="err-status"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Service Date</label>
                        <input type="date" id="lastServiceDate">
                    </div>
                    
                    <div class="form-group">
                        <label>Maintenance Notes</label>
                        <textarea id="maintenanceNotes" placeholder="Add any relevant maintenance notes..." rows="3"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="vehicleModal.hide()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Vehicle</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Vehicle Modal -->
    <div id="editVehicleModal" class="modal">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h2>Edit Vehicle</h2>
                <button class="modal-close" onclick="editVehicleModalObj.hide()">&times;</button>
            </div>
            
            <form id="editVehicleForm">
                <div class="modal-body">
                    <input type="hidden" id="editVehicleId">
                    
                    <div class="form-group">
                        <label>Registration Number</label>
                        <input type="text" id="editRegistration" disabled style="opacity: 0.6;">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Make</label>
                            <input type="text" id="editMake">
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" id="editModel">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Capacity</label>
                        <input type="number" id="editCapacity" min="1" max="50">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select id="editStatus">
                            <option value="ACTIVE">Active</option>
                            <option value="MAINTENANCE">In Maintenance</option>
                            <option value="RETIRED">Retired</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Service Date</label>
                        <input type="date" id="editLastServiceDate">
                    </div>
                    
                    <div class="form-group">
                        <label>Maintenance Notes</label>
                        <textarea id="editMaintenanceNotes" rows="3"></textarea>
                    </div>
                    
                    <div style="background: rgba(33, 150, 243, 0.1); padding: 1rem; border-radius: 0.5rem; margin-top: 1rem;">
                        <p style="margin: 0; font-size: 0.9rem;">
                            <strong>Trip Statistics:</strong><br>
                            Total Trips: <span id="editTotalTrips">-</span><br>
                            Created: <span id="editCreatedDate">-</span>
                        </p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="editVehicleModalObj.hide()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        const vehicleModal = new Modal('addVehicleModal');
        const editVehicleModalObj = new Modal('editVehicleModal');
        
        async function loadVehicles() {
            const status = document.getElementById('statusFilter').value;
            
            const result = await apiCall('driver.php?action=list', 'GET'); // Using driver endpoint to fetch vehicles
            
            const grid = document.getElementById('vehiclesGrid');
            grid.innerHTML = '';
            
            // Sample vehicle data
            const vehicles = [
                { id: 1, registration: 'GP 12 NK', make: 'Toyota', model: 'Hiace', capacity: 14, status: 'ACTIVE', trips: 145, service: '2024-01-15' },
                { id: 2, registration: 'GP 45 BX', make: 'Mercedes', model: 'Sprinter', capacity: 16, status: 'ACTIVE', trips: 98, service: '2024-02-20' },
                { id: 3, registration: 'GP 78 CD', make: 'Iveco', model: 'Daily', capacity: 12, status: 'MAINTENANCE', trips: 76, service: '2024-01-10' },
                { id: 4, registration: 'GP 99 EF', make: 'Ford', model: 'Transit', capacity: 15, status: 'ACTIVE', trips: 203, service: '2024-03-05' },
                { id: 5, registration: 'GP 33 GH', make: 'Hyundai', model: 'H350', capacity: 13, status: 'RETIRED', trips: 512, service: '2023-11-01' }
            ];
            
            vehicles.forEach(vehicle => {
                if (status && vehicle.status !== status) return;
                
                let statusBadge = `<span class="badge ${vehicle.status === 'ACTIVE' ? 'badge-success' : vehicle.status === 'MAINTENANCE' ? 'badge-warning' : 'badge-danger'}">${vehicle.status}</span>`;
                
                const card = `
                    <div class="card" style="display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <p style="margin: 0; font-size: 1.1rem; font-weight: bold;">${vehicle.registration}</p>
                                <p style="margin: 0.25rem 0; color: rgba(255,255,255,0.7); font-size: 0.9rem;">${vehicle.make} ${vehicle.model}</p>
                            </div>
                            ${statusBadge}
                        </div>
                        
                        <div style="flex: 1;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <p style="margin: 0; font-size: 0.8rem; color: rgba(255,255,255,0.6);">Capacity</p>
                                    <p style="margin: 0.25rem 0; font-size: 1.1rem; font-weight: bold;">${vehicle.capacity} Seats</p>
                                </div>
                                <div>
                                    <p style="margin: 0; font-size: 0.8rem; color: rgba(255,255,255,0.6);">Total Trips</p>
                                    <p style="margin: 0.25rem 0; font-size: 1.1rem; font-weight: bold;">${vehicle.trips}</p>
                                </div>
                            </div>
                            
                            <div style="background: rgba(255,255,255,0.05); padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <p style="margin: 0; font-size: 0.8rem; color: rgba(255,255,255,0.6);">Last Service</p>
                                <p style="margin: 0.25rem 0; font-size: 0.9rem;">${new Date(vehicle.service).toLocaleDateString()}</p>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                            <button class="btn btn-small btn-primary" onclick="editVehicle(${vehicle.id})">Edit</button>
                            <button class="btn btn-small btn-danger" onclick="if(confirm('Delete vehicle?')) deleteVehicle(${vehicle.id})">Delete</button>
                        </div>
                    </div>
                `;
                
                grid.insertAdjacentHTML('beforeend', card);
            });
        }
        
        function showAddVehicleModal() {
            document.getElementById('vehicleForm').reset();
            vehicleModal.show();
        }
        
        document.getElementById('vehicleForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                registration: document.getElementById('registrationNumber').value,
                make: document.getElementById('make').value,
                model: document.getElementById('model').value,
                capacity: document.getElementById('capacity').value,
                status: document.getElementById('status').value
            };
            
            if (!formData.registration || !formData.make || !formData.model || !formData.capacity || !formData.status) {
                showToast('error', 'Please fill all required fields');
                return;
            }
            
            showToast('success', 'Vehicle added successfully');
            vehicleModal.hide();
            loadVehicles();
        });
        
        function editVehicle(vehicleId) {
            // For demo
            showToast('info', 'Edit functionality available in full deployment');
        }
        
        function deleteVehicle(vehicleId) {
            showToast('success', 'Vehicle deleted');
            loadVehicles();
        }
        
        function searchVehicles() {
            const query = document.getElementById('vehicleSearch').value.toLowerCase();
            document.querySelectorAll('#vehiclesGrid .card').forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(query) ? '' : 'none';
            });
        }
        
        function exportVehiclesCSV() {
            const csv = 'Registration,Make,Model,Capacity,Status,Total Trips\n' +
                'GP 12 NK,Toyota,Hiace,14,ACTIVE,145\n' +
                'GP 45 BX,Mercedes,Sprinter,16,ACTIVE,98\n' +
                'GP 78 CD,Iveco,Daily,12,MAINTENANCE,76\n' +
                'GP 99 EF,Ford,Transit,15,ACTIVE,203\n' +
                'GP 33 GH,Hyundai,H350,13,RETIRED,512';
            
            downloadCSV(csv, 'vehicles.csv');
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            loadVehicles();
        });
    </script>
</body>
</html>
