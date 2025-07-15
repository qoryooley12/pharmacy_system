<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Prescription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f2f5f7;
      font-family: 'Segoe UI', sans-serif;
      padding: 20px;
    }
    .prescription-container {
      background: #fff;
      padding: 40px;
      max-width: 900px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 30px rgba(0,0,0,0.1);
    }
    .pharmacy-header h2 {
      color: #0d6efd;
      font-weight: 700;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }
    .pharmacy-contact {
      font-size: 0.9rem;
      color: #6c757d;
      margin-bottom: 20px;
    }
    .section-title {
      color: #0d6efd;
      margin-top: 30px;
      margin-bottom: 10px;
      font-weight: 600;
      border-bottom: 2px solid #0d6efd;
      padding-bottom: 5px;
    }
    table.prescription-table th {
      background-color: #e7f1ff;
      color: #0d6efd;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.9rem;
    }
    table.prescription-table th,
    table.prescription-table td {
      border: 1px solid #dee2e6;
      padding: 10px;
      font-size: 0.95rem;
      vertical-align: top;
    }
    #qrcode {
      margin-top: 20px;
      display: flex;
      justify-content: center;
    }
    .editable-field {
      background: #f8f9fa;
      padding: 2px 6px;
      border-radius: 4px;
      display: inline-block;
      transition: background 0.3s;
    }
    .editable-field:hover {
      background: #d9f0ff;
      cursor: pointer;
    }
    .btn-custom {
      background: #0d6efd;
      color: #fff;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-custom:hover {
      background: #0b5ed7;
    }
    @media print {
      body * {
        visibility: hidden;
      }
      #printable, #printable * {
        visibility: visible;
      }
      #printable {
        position: absolute;
        top: 0;
        left: 0;
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        box-sizing: border-box;
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<div class="page-wrapper">
  <div class="content container-fluid">

    <!-- FORM SECTION -->
    <div class="no-print mb-4">
      <div class="card p-4 shadow-sm border-0">
        <h4 class="mb-4 text-primary fw-bold">
          <i class="bi bi-file-earmark-medical"></i> Create Prescription
        </h4>

        <!-- Patient Select -->
        <label class="form-label fw-semibold">Select Patient</label>
      <select id="patientSelect" class="form-select">
  <option value="">-- Select Patient --</option>
  <?php
    include "../config/conn.php";
    $sql = "SELECT id, name FROM patient ORDER BY name ASC";
    $res = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($res)) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
    }
  ?>
</select>

        <!-- Patient Info -->
        <div class="border p-3 mb-3 bg-light rounded">
          <div class="row">
            <div class="col-md-4">
              <strong>Patient Name:</strong>
              <span id="patientNameField">---</span>
            </div>
            <div class="col-md-3">
              <strong>Patient ID:</strong>
              <span id="patientIdField">---</span>
            </div>
            <div class="col-md-3">
              <strong>Age / Sex:</strong>
              <span id="ageSexField">---</span>
            </div>
          </div>
        </div>

        <!-- Doctor -->
        <label class="form-label fw-semibold">Doctor Name</label>
        <input type="text" class="form-control mb-3" id="doctorInput" placeholder="Enter doctor's name" />

        <!-- Medication Inputs -->
        <h5 class="section-title">Add Medication</h5>
        <div class="row g-2 mb-3">
          <div class="col-md-3">
            <input type="text" class="form-control" id="drugName" placeholder="Drug Name">
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" id="dosage" placeholder="Dosage">
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" id="frequency" placeholder="Frequency">
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" id="duration" placeholder="Duration">
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" id="notes" placeholder="Notes">
          </div>
        </div>
        <button class="btn btn-custom" onclick="addMedication()">
          <i class="bi bi-plus-circle"></i> Add Medication
        </button>
      </div>
    </div>

    <!-- PRINTABLE SECTION -->
    <div class="prescription-container" id="printable">
      <div class="pharmacy-header text-center">
        <h2>Deris Uroone Pharmacy & Medical Laboratory</h2>
        <div class="pharmacy-contact">Qoryooley, Somalia | +252615599345 | +252613765455</div>
      </div>
      <hr>
      <div class="row mb-3">
        <div class="col-md-6">
          <p><strong>Patient Name:</strong> <span id="patientName">---</span></p>
          <p><strong>Patient ID:</strong> <span id="patientId">---</span></p>
          <p><strong>Age / Sex:</strong> <span id="ageSex">---</span></p>
        </div>
        <div class="col-md-6 text-end">
          <p><strong>Date:</strong> <span id="prescDate">---</span></p>
          <p><strong>Doctor:</strong> <span id="doctorName">---</span></p>
        </div>
      </div>
      <h5 class="section-title">Prescribed Medications</h5>
      <div class="table-responsive">
        <table class="table prescription-table w-100">
          <thead>
            <tr>
              <th>#</th>
              <th>Drug Name</th>
              <th>Dosage</th>
              <th>Frequency</th>
              <th>Duration</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody id="medicationTableBody"></tbody>
        </table>
      </div>
      <div id="qrcode"></div>
      <div class="text-center mt-4 pharmacy-contact">
        Get well soon! Thanks for choosing Deris Uroone Pharmacy.
      </div>
    </div>

    <div class="text-center mt-4 no-print">
      <button class="btn btn-success me-2" onclick="generatePrescription()">
        <i class="bi bi-qr-code"></i> Generate Prescription
      </button>
      <button class="btn btn-secondary" onclick="window.print()">
        <i class="bi bi-printer"></i> Print
      </button>
    </div>

  </div>
</div>

<!-- Edit Patient Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Patient Info</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Patient Name</label>
          <input type="text" class="form-control" id="editPatientName">
        </div>
        <div class="mb-3">
          <label class="form-label">Patient ID</label>
          <input type="text" class="form-control" id="editPatientId">
        </div>
        <div class="mb-3">
          <label class="form-label">Age / Sex</label>
          <input type="text" class="form-control" id="editAgeSex">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal" onclick="saveEdits()">
          Save Changes
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.js"></script>
<script>
  let medications = [];

  document.getElementById('patientSelect').addEventListener('change', function() {
  const patientId = this.value;
  if (!patientId) return;

  fetch("../api/fetch_patient2.php?id=" + patientId)
    .then(res => res.json())
    .then(data => {
      if (data) {
        document.getElementById("patientNameField").textContent = data.name || "---";
        document.getElementById("patientIdField").textContent = data.patient_no || "---";
        document.getElementById("ageSexField").textContent = (data.age || "---") + " / " + (data.gender || "---");

        // Optionally update hidden fields or the printable version:
        document.getElementById("patientName").textContent = data.name || "---";
        document.getElementById("patientId").textContent = data.patient_no || "---";
        document.getElementById("ageSex").textContent = (data.age || "---") + " / " + (data.gender || "---");

        // If you want to fill address or other details somewhere, do it here:
        console.log(data);
      }
    });
});


  function updatePatientFields(name, id, ageSex) {
    document.getElementById("patientNameField").textContent = name || "---";
    document.getElementById("patientIdField").textContent = id || "---";
    document.getElementById("ageSexField").textContent = ageSex || "---";

    document.getElementById("patientName").textContent = name || "---";
    document.getElementById("patientId").textContent = id || "---";
    document.getElementById("ageSex").textContent = ageSex || "---";

    document.getElementById("editPatientName").value = name || "";
    document.getElementById("editPatientId").value = id || "";
    document.getElementById("editAgeSex").value = ageSex || "";
  }

  function saveEdits() {
    updatePatientFields(
      document.getElementById("editPatientName").value,
      document.getElementById("editPatientId").value,
      document.getElementById("editAgeSex").value
    );
  }

  function addMedication() {
    const med = {
      name: document.getElementById("drugName").value,
      dosage: document.getElementById("dosage").value,
      frequency: document.getElementById("frequency").value,
      duration: document.getElementById("duration").value,
      notes: document.getElementById("notes").value
    };
    if (!med.name) {
      alert("Please enter a drug name!");
      return;
    }
    medications.push(med);
    renderMedications();
    clearMedInputs();
  }

  function renderMedications() {
    const tbody = document.getElementById("medicationTableBody");
    tbody.innerHTML = "";
    medications.forEach((med, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${med.name}</td>
        <td>${med.dosage}</td>
        <td>${med.frequency}</td>
        <td>${med.duration}</td>
        <td>${med.notes}</td>
      `;
      tbody.appendChild(tr);
    });
  }

  function clearMedInputs() {
    document.getElementById("drugName").value = "";
    document.getElementById("dosage").value = "";
    document.getElementById("frequency").value = "";
    document.getElementById("duration").value = "";
    document.getElementById("notes").value = "";
  }

  function generatePrescription() {
    const doctor = document.getElementById("doctorInput").value || "Dr. ---";
    const today = new Date().toISOString().split('T')[0];

    document.getElementById("doctorName").textContent = doctor;
    document.getElementById("prescDate").textContent = today;

    const patientName = document.getElementById("patientName").textContent;
    const patientId = document.getElementById("patientId").textContent;

    const qrText = `Patient: ${patientName}\nID: ${patientId}\nDoctor: ${doctor}\nDate: ${today}`;
    document.getElementById("qrcode").innerHTML = "";
    new QRCode(document.getElementById("qrcode"), {
      text: qrText,
      width: 128,
      height: 128
    });
  }
</script>

</body>
</html>
