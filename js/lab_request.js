let patientsData = [];
const allTests = [
  { id: 1, name: "Complete Blood Count" },
  { id: 2, name: "Glucose" },
  { id: 3, name: "Cholesterol" },
  { id: 4, name: "Liver Function Test" },
  { id: 5, name: "Kidney Function Test" },
  { id: 6, name: "Malaria Smear" },
  { id: 7, name: "Typhoid Test" },
  { id: 8, name: "Urinalysis" }
];

$(document).ready(function () {
  // Initialize Select2
  $("#patientSelect").select2({
    placeholder: "Select patient...",
    allowClear: true,
    ajax: {
      url: "../api/labrequest_Api.php",
      dataType: "json",
      processResults: function (data) {
        patientsData = data;
        return {
          results: data.map(p => ({
            id: p.id,
            text: `${p.name} (ID: ${p.patient_no})`,
            data: p
          }))
        };
      }
    }
  });

  // Create test checkboxes
  const checkDiv = document.getElementById("testsCheckboxes");
  allTests.forEach(t => {
    const div = document.createElement("div");
    div.className = "col-md-6 mb-2";
    div.innerHTML = `
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="test-${t.id}" value="${t.name}">
        <label class="form-check-label" for="test-${t.id}">${t.name}</label>
      </div>`;
    checkDiv.appendChild(div);
  });
});

// Handle form submission
document.getElementById("labForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const selectedId = $("#patientSelect").val();
  if (!selectedId) {
    alert("Please select a patient!");
    return;
  }

  const patient = patientsData.find(p => p.id == selectedId);
  if (!patient) {
    alert("Selected patient not found!");
    return;
  }

  const doctor = $("#doctorName").val();
  const date = new Date().toISOString().split("T")[0];

  const selectedTests = [];
  allTests.forEach(test => {
    const box = document.getElementById(`test-${test.id}`);
    if (box.checked) selectedTests.push(test.name);
  });

  if (selectedTests.length === 0) {
    alert("Please select at least one test!");
    return;
  }

  // Save lab request to database
  $.ajax({
    url: "../api/save_lab_request.php",
    method: "POST",
    data: {
      patient_id: patient.id,
      doctor: doctor,
      tests: selectedTests
    },
    success: function(response) {
      let res;
      try {
        res = typeof response === "object" ? response : JSON.parse(response);
      } catch (e) {
        console.error("Invalid JSON response:", response);
        alert("Server returned invalid data.");
        return;
      }

      if (res.success) {
        console.log("Saved successfully");
        generatePrint(patient, doctor, selectedTests, date);
      } else {
        alert("Failed to save: " + res.message);
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX error:", error);
      alert("An error occurred. Check console for details.");
    }
  });
});

function generatePrint(patient, doctor, selectedTests, date) {
  document.getElementById("printPatientName").textContent = patient.name;
  document.getElementById("printPatientId").textContent = patient.patient_no;
  document.getElementById("printAgeSex").textContent = `${patient.age} / ${patient.gender}`;
  document.getElementById("printDate").textContent = date;
  document.getElementById("printDoctorName").textContent = doctor;

  const list = document.getElementById("printTestsList");
  list.innerHTML = "";
  selectedTests.forEach(test => {
    const li = document.createElement("li");
    li.className = "list-group-item";
    li.textContent = test;
    list.appendChild(li);
  });

  const qrText = `
    Pharmacy: Deris Uroone Pharmacy
    Patient Name: ${patient.name}
    Patient ID: ${patient.patient_no}
    Age/Sex: ${patient.age}/${patient.gender}
    Phone: ${patient.phone}
    Doctor: ${doctor}
    Tests: ${selectedTests.join(", ")}
    Date: ${date}
  `;

  document.getElementById("qrcode").innerHTML = "";
  new QRCode(document.getElementById("qrcode"), {
    text: qrText,
    width: 128,
    height: 128
  });

  document.getElementById("printSection").classList.remove("d-none");
  window.print();
}