

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lab Result Entry</title>
  <style>
    body {
      background: #f8f9fa;
    }
    @media print {
      @page {
        size: A4 portrait;
        margin: 10mm;
      }
      body * {
        visibility: hidden;
      }
      #printSection, #printSection * {
        visibility: visible;
      }
      #printSection {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 0;
        margin: 0;
      }
      .no-print {
        display: none !important;
      }
    }
    .pharmacy-header {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .pharmacy-header i {
      font-size: 50px;
      color: #0d6efd;
    }
    .pharmacy-name {
      font-weight: bold;
      font-size: 1.5rem;
      color: #0d6efd;
      text-align: center;
    }
    .pharmacy-contact {
      text-align: center;
      font-size: 0.9rem;
      color: #6c757d;
    }
    #qrcode {
      margin: 0 auto;
      width: 128px;
      height: 128px;
    }
  </style>
</head>
<body>
    <div class="page-wrapper">
<div class="container-fluid py-4">
<div class="container py-4">
  <div class="bg-white p-4 rounded shadow-sm">
    <h4 class="mb-3 text-primary">Lab Result Entry</h4>

    <form id="resultForm">
      <div class="mb-3">
        <label class="form-label">Select Lab Request</label>
        <select class="form-select" id="labRequestSelect">
          <option value="">-- Select Lab Request --</option>
          <?php
            include "../config/conn.php";
            $sql = "SELECT id, patient_id, doctor_name, requested_tests, request_date FROM lab_requests";
            $res = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($res)){
                $val = htmlspecialchars(json_encode($row));
                echo "<option value='$val'>Request #{$row['id']} | Dr. {$row['doctor_name']}</option>";
            }
          ?>
        </select>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Patient Name</label>
          <input type="text" class="form-control" id="patientName" readonly />
        </div>
        <div class="col-md-3">
          <label class="form-label">Patient ID</label>
          <input type="text" class="form-control" id="patientId" readonly />
        </div>
        <div class="col-md-3">
          <label class="form-label">Age / Sex</label>
          <input type="text" class="form-control" id="ageSex" readonly />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Doctor Name</label>
          <input type="text" class="form-control" id="doctorName" readonly />
        </div>
        <div class="col-md-6">
          <label class="form-label">Date</label>
          <input type="date" class="form-control" id="requestDate" readonly />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Test Results</label>
        <div class="row" id="testResults">
          <!-- dynamically loaded inputs -->
        </div>
      </div>

      <button type="submit" class="btn btn-primary no-print">Generate & Print</button>
    </form>
  </div>
</div>

<!-- Printable Section -->
<div id="printSection" class="mt-5 d-none">
  <!-- Pharmacy Header -->
  <div class="pharmacy-header">
    <i class="bi bi-heart-pulse-fill"></i>
    <span class="pharmacy-name">Deris Uroone Pharmacy and Medical Laboratory</span>
  </div>

  <div class="pharmacy-contact">
    Qoryooley - Somalia | Tel: +252615599345, +252613765455, +252617618145
  </div>

  <hr class="my-3"/>

  <h3 class="text-center text-primary mb-4">Lab Result Sheet</h3>

  <table class="table table-bordered">
    <tbody>
      <tr>
        <th class="w-25">Patient Name</th>
        <td id="printPatientName"></td>
      </tr>
      <tr>
        <th>Patient ID</th>
        <td id="printPatientId"></td>
      </tr>
      <tr>
        <th>Age / Sex</th>
        <td id="printAgeSex"></td>
      </tr>
      <tr>
        <th>Date</th>
        <td id="printDate"></td>
      </tr>
      <tr>
        <th>Doctor</th>
        <td id="printDoctorName"></td>
      </tr>
    </tbody>
  </table>

  <h5 class="mb-2 text-primary">Test Results:</h5>
  <table class="table table-bordered table-sm">
    <thead class="table-light">
      <tr>
        <th>Test</th>
        <th>Result</th>
      </tr>
    </thead>
    <tbody id="printResultsTable"></tbody>
  </table>

  <div class="text-center mt-4">
    <div id="qrcode"></div>
  </div>

  <div class="pharmacy-contact mt-4">
    Thanks for choosing Deris Uroone Pharmacy and Medical Laboratory.
  </div>
</div>
        </div>
        </div>

<script>
document.getElementById("labRequestSelect").addEventListener("change", function(){
    const val = this.value;
    if (!val) return;

    const data = JSON.parse(val);

    document.getElementById("doctorName").value = data.doctor_name;
    document.getElementById("requestDate").value = data.request_date;

    // Load patient data
    fetch("../api/fetch_patient.php?id=" + data.patient_id)
      .then(res => res.json())
      .then(patient => {
        document.getElementById("patientName").value = patient.name;
        document.getElementById("patientId").value = patient.patient_no;
        document.getElementById("ageSex").value = patient.age + " / " + patient.gender;

        // store in select for later use
        document.getElementById("labRequestSelect").dataset.patient = JSON.stringify(patient);
      });

    // Build test result fields
    const container = document.getElementById("testResults");
    container.innerHTML = "";
    if (data.requested_tests) {
        data.requested_tests.split(",").forEach(test => {
            const col = document.createElement("div");
            col.className = "col-md-6 mb-2";
            col.innerHTML = `
              <label class="form-label">${test}</label>
              <input type="text" class="form-control" name="result_${test}" placeholder="Enter result for ${test}" />
            `;
            container.appendChild(col);
        });
    }
});

document.getElementById("resultForm").addEventListener("submit", function(e){
    e.preventDefault();

    const val = document.getElementById("labRequestSelect").value;
    const data = JSON.parse(val);
    const patient = JSON.parse(document.getElementById("labRequestSelect").dataset.patient || "{}");

    document.getElementById("printPatientName").textContent = patient.name || "";
    document.getElementById("printPatientId").textContent = patient.patient_no || "";
    document.getElementById("printAgeSex").textContent = (patient.age || "") + " / " + (patient.gender || "");
    document.getElementById("printDoctorName").textContent = document.getElementById("doctorName").value || "";
    document.getElementById("printDate").textContent = document.getElementById("requestDate").value || "";

    const table = document.getElementById("printResultsTable");
    table.innerHTML = "";
    document.querySelectorAll("#testResults input").forEach(input => {
      if(input.value){
        const tr = document.createElement("tr");
        tr.innerHTML = `<td>${input.previousElementSibling.textContent}</td><td>${input.value}</td>`;
        table.appendChild(tr);
      }
    });

    // generate QR code
    const qrDiv = document.getElementById("qrcode");
    qrDiv.innerHTML = "";
    const qrText = `Patient: ${patient.name}\nID: ${patient.patient_no}\nDoctor: ${document.getElementById("doctorName").value}\nDate: ${document.getElementById("requestDate").value}`;
    new QRCode(qrDiv, { text: qrText, width: 128, height: 128 });

    document.getElementById("printSection").classList.remove("d-none");
    window.print();
});
</script>
</body>
</html>
