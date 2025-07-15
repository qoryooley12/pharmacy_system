
<div class="page-wrapper">
  <div class="content container-fluid">

    <!-- PAGE HEADER -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="page-title text-primary fw-bold">Users Registration</h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- USERS TABLE -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(45deg, #4e73df, #224abe);">
            <h5 class="mb-0 fw-bold"><i class="bi bi-people-fill me-2"></i> Users List</h5>
            <button class="btn btn-light text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="bi bi-plus-circle me-1"></i> Add New User
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-primary">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Profile</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody id="usersTable">
                <!-- this will fetch data dynamically -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ============= Add User Modal ============= -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="addUserForm" enctype="multipart/form-data">
      <div class="modal-content border-0 shadow">
        <div class="modal-header text-white" style="background: linear-gradient(45deg, #4e73df, #224abe);">
          <h5 class="modal-title fw-bold" id="addUserModalLabel"><i class="bi bi-person-plus me-2"></i> Register New User</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Full Name</label>
              <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Choose a username" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Role</label>
              <select name="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Pharmacist">Pharmacist</option>
                <option value="Cashier">Cashier</option>
                <option value="User">User</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" class="form-select" required>
                <option value="">Select Status</option>
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Profile Photo</label>
              <input type="file" name="profile" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer p-3">
          <button type="submit" class="btn btn-success fw-semibold">
            <i class="bi bi-check-circle me-1"></i> Save User
          </button>
          <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
        </div>
      </div>
    </form>
  </div>
</div>





<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editUserForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="edit_user_id">
          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" id="edit_full_name" class="form-control">
          </div>
          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" id="edit_username" class="form-control">
          </div>
          <div class="mb-3">
            <label>Role</label>
            <select name="role" id="edit_role" class="form-control">
              <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Pharmacist">Pharmacist</option>
                <option value="Cashier">Cashier</option>
                <option value="User">User</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Status</label>
            <select name="status" id="edit_status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update User</button>
        </div>
      </div>
    </form>
  </div>
</div>
