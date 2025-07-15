

<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="row">
        <div class="col">
          <h3 class="page-title">Data Tables</h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Tables</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
     <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Patient List</h5>
  <div class="d-flex gap-2">
    <button class="btn btn-danger" id="deleteAllBtn">
      <i class="bi bi-trash3 me-1"></i> Delete All Patients
    </button>
    <button class="btn btn-danger" id="btnDeletedPatients">
      <i class="bi bi-archive me-1"></i> All Deleted Patients
    </button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
      <i class="bi bi-plus-lg me-1"></i> Add New Patient
    </button>
  </div>
</div>


          <div class="card-body">
            <div class="table-responsive" >
              <table class="table table-striped" id="patientTable">
                <thead class="table-light">
                  <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="tBody">
                  <!-- this data will come from database -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="PatientForm" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="patientName" class="form-label">Name</label>
              <input type="text" class="form-control" id="patientName" name="patientName" placeholder="Enter name">
            </div>
            <div class="col-md-6">
              <label for="patientPhone" class="form-label">Phone</label>
              <input type="text" class="form-control" id="patientPhone" name="patientPhone" placeholder="Enter phone">
            </div>
            <div class="col-md-6">
              <label for="patientGender" class="form-label">Gender</label>
              <select class="form-select" id="patientGender" name="patientGender">
                <option selected disabled>Choose...</option>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="patientAge" class="form-label">Age</label>
              <input type="number" class="form-control" id="patientAge" name="patientAge" placeholder="Enter age">
            </div>
            <div class="col-md-12">
              <label for="patientAddress" class="form-label">Address</label>
              <input type="text" class="form-control" id="patientAddress" name="patientAddress" placeholder="Enter address">
            </div>
            <div class="col-md-12">
              <label for="patientConditions" class="form-label">Medical Conditions</label>
              <textarea class="form-control" id="patientConditions" name="patientConditions" rows="2" placeholder="Enter medical conditions"></textarea>
            </div>
            <!-- <div class="col-md-12">
              <label for="patientAllergies" class="form-label">Allergies</label>
              <textarea class="form-control" id="patientAllergies" rows="2" placeholder="Enter allergies"></textarea>
            </div> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Patient</button>
        </div>
      </form>
    </div>
  </div>
</div>




<div class="modal fade" id="editPatientModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editPatientForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Patient</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">

        <div class="row g-3">
          <div class="col-md-6">
            <label for="edit_name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="edit_name">
          </div>

          <div class="col-md-6">
            <label for="edit_phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="edit_phone">
          </div>

          <div class="col-md-6">
            <label for="edit_gender" class="form-label">Gender</label>
            <select class="form-select" name="gender" id="edit_gender">
              <option selected disabled>Choose...</option>
              <option>Male</option>
              <option>Female</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="edit_age" class="form-label">Age</label>
            <input type="number" class="form-control" name="age" id="edit_age">
          </div>

          <div class="col-md-12">
            <label for="edit_address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" id="edit_address">
          </div>

          <div class="col-md-12">
            <label for="edit_conditions" class="form-label">Medical Conditions</label>
            <textarea class="form-control" name="medical_conditions" id="edit_conditions" rows="2"></textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Patient</button>
      </div>
    </form>
  </div>
</div>
