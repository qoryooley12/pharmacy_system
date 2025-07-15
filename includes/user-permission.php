
<div class="page-wrapper">
  <div class="container-fluid py-4">
    <div class="container mt-4">

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Assign Permissions to Users</h4>
        </div>

        <div class="card-body">

          <!-- User Selection -->
          <div class="mb-4">
            <label class="form-label">Select User</label>
            <select class="form-select" name="user_id" id="userSelect">
              <option value="">-- Select User --</option>
              <!-- populate dynamically -->
            </select>
          </div>

          <!-- Permissions Checkboxes -->
          <div id="permissionsSection" class="d-none">
            <h5 class="mb-3">Assign Permissions</h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="dashboard" id="permDashboard">
                  <label class="form-check-label" for="permDashboard">Dashboard</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="patients" id="permPatients">
                  <label class="form-check-label" for="permPatients">Patients</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="laboratory" id="permLaboratory">
                  <label class="form-check-label" for="permLaboratory">Laboratory</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="pharmacy" id="permPharmacy">
                  <label class="form-check-label" for="permPharmacy">Pharmacy</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="sales" id="permSales">
                  <label class="form-check-label" for="permSales">Sales</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="purchases" id="permPurchases">
                  <label class="form-check-label" for="permPurchases">Purchases</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="inventory" id="permInventory">
                  <label class="form-check-label" for="permInventory">Inventory</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="reports" id="permReports">
                  <label class="form-check-label" for="permReports">Reports</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="permissions[]" value="settings" id="permSettings">
                  <label class="form-check-label" for="permSettings">Settings</label>
                </div>
              </div>
            </div>

            <button class="btn btn-success mt-3" id="savePermissions">
              Save Permissions
            </button>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
