$(document).ready(function () {
  let patients = [];

  function renderPatients(data) {
    let html = "";

    data.forEach(p => {
      let initials = p.name.slice(0, 2).toUpperCase();
      html += `
        <div class="col-md-3">
          <div class="patient-card">
            <div class="patient-circle">${initials}</div>
            <h5>${p.name}</h5>
            <p class="text-muted">${p.phone}</p>
            <p class="text-muted">${p.address}</p>
          </div>
        </div>
      `;
    });

    $("#patientGrid").html(html);
  }

 function reload() {
  $.ajax({
    type: "POST",
    url: "../api/patient_api.php",
    data: { action: "fetchAllPatients" },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        patients = response.data;

        renderPatients(patients);

        let table;
        if (!$.fn.DataTable.isDataTable('#patientTable')) {
          table = $('#patientTable').DataTable({
            responsive: true,
            stateSave: false
          });
        } else {
          table = $('#patientTable').DataTable();
          table.clear();
        }

        patients.forEach(patient => {
          table.row.add([
            patient.patient_no,
            patient.name,
            patient.phone,
            `
            <button class="btn btn-sm btn-info rounded-circle view-btn" data-id="${patient.id}">
              <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning rounded-circle edit-btn" data-id="${patient.id}">
              <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-danger rounded-circle delete-btn" data-id="${patient.id}">
              <i class="bi bi-trash"></i>
            </button>
            `
          ]);
        });

        table.draw();

      } else {
        Swal.fire({
          icon: "error",
          title: "Xog lama helin!",
          text: response.message
        });
      }
    }
  });
}


  // Initial load
  reload();

  // Live search
  $("#searchPatient").on("keyup", function () {
    let keyword = $(this).val().toLowerCase();
    let filtered = patients.filter(p => p.name.toLowerCase().includes(keyword) || p.phone.includes(keyword));
    renderPatients(filtered);
  });

  // Add Patient
  $(document).on("submit", "#PatientForm", function (e) {
    e.preventDefault();
    let formdata = new FormData(this);
    formdata.append("action", "insertF");

    $.ajax({
      type: "POST",
      url: "../api/patient_api.php",
      data: formdata,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          Swal.fire({ title: "Good job!", text: "Patient saved with ID: " + response.patient_no, icon: "success" }).then(() => {
            $("#addPatientModal").modal("hide");
            $("#PatientForm")[0].reset();
            reload();
          });
        } else {
          Swal.fire({ title: "Error!", text: response.message, icon: "error" });
        }
      }
    });
  });

  // View Patient
  $(document).on("click", ".view-btn", function () {
    let id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "../api/patient_api.php",
      data: { action: "fetchSinglePatient", id: id },
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          let p = res.data;
          Swal.fire({
            title: `Macluumaadka: ${p.name}`,
            html: `
              <table class="table table-bordered table-sm">
                <tbody>
                  <tr><th>Patient No</th><td>${p.patient_no}</td></tr>
                  <tr><th>Magaca</th><td>${p.name}</td></tr>
                  <tr><th>Telefoon</th><td>${p.phone}</td></tr>
                  <tr><th>Jinsiga</th><td>${p.gender}</td></tr>
                  <tr><th>Da'da</th><td>${p.age}</td></tr>
                  <tr><th>Address</th><td>${p.address}</td></tr>
                  <tr><th>Conditions</th><td>${p.medical_conditions}</td></tr>
                </tbody>
              </table>`,
            icon: "info"
          });
        } else {
          Swal.fire({ icon: "error", title: "Error", text: res.message });
        }
      }
    });
  });

  // Edit Patient (open modal)
  $(document).on("click", ".edit-btn", function () {
    let id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "../api/patient_api.php",
      data: { action: "fetchSinglePatient", id: id },
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          let p = res.data;
          $("#edit_id").val(p.id);
          $("#edit_name").val(p.name);
          $("#edit_phone").val(p.phone);
          $("#edit_gender").val(p.gender);
          $("#edit_age").val(p.age);
          $("#edit_address").val(p.address);
          $("#edit_conditions").val(p.medical_conditions);
          $("#editPatientModal").modal("show");
        } else {
          Swal.fire({ icon: "error", title: "Error", text: res.message });
        }
      }
    });
  });

  // Submit edit form
  $(document).on("submit", "#editPatientForm", function (e) {
    e.preventDefault();
    let formdata = new FormData(this);
    formdata.append("action", "updatePatient");

    $.ajax({
      type: "POST",
      url: "../api/patient_api.php",
      data: formdata,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          Swal.fire({ icon: "success", title: "Updated!", text: "Patient updated successfully." }).then(() => {
            $("#editPatientModal").modal("hide");
            reload();
          });
        } else {
          Swal.fire({ icon: "error", title: "Error!", text: res.message });
        }
      }
    });
  });


  // Delete Patient
$(document).on("click", ".delete-btn", function () {
  let id = $(this).data("id");

  Swal.fire({
    title: "Ma hubtaa?",
    text: "inaad delete gareyso bukaankaan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Haa, tirtiro!",
    cancelButtonText: "Maya"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "../api/patient_api.php",
        data: { action: "deletePatient", id: id },
        dataType: "json",
        success: function (res) {
          if (res.status === "success") {
            Swal.fire("Tirtirmay!", res.message, "success");
            reload();
          } else {
            Swal.fire("Error!", res.message, "error");
          }
        }
      });
    }
  });
});






$(document).on("click", "#deleteAllBtn", function () {
  Swal.fire({
    title: "Ma hubtaa?",
    text: "Tani waxay tirtiri doontaa dhammaan bukaannada!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Haa, tirtir!",
    cancelButtonText: "Ka noqo"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "../api/patient_api.php",
        data: { action: "deleteAllPatients" },
        dataType: "json",
        success: function (res) {
          if (res.status === "success") {
            Swal.fire("La tirtiray!", res.message, "success");
            reload(); // dib u celi table-ka
          } else {
            Swal.fire("Error!", res.message, "error");
          }
        },
        error: function () {
          Swal.fire("Error!", "Qalad xiriir ah ayaa dhacay.", "error");
        }
      });
    }
  });
});


$(document).on("click", "#btnDeletedPatients", function () {
  $.ajax({
    type: "POST",
    url: "../api/patient_api.php",
    data: { action: "fetchAllDeletedPatients" },
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        let rows = "";
        res.data.forEach(p => {
          rows += `
            <tr>
              <td>${p.patient_no}</td>
              <td>${p.name}</td>
              <td>${p.phone}</td>
              <td>${p.deleted_at}</td>
            </tr>
          `;
        });

        Swal.fire({
          title: "Deleted Patients",
          html: `
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Patient No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Deleted At</th>
                  </tr>
                </thead>
                <tbody>
                  ${rows}
                </tbody>
              </table>
            </div>
          `,
          width: '80%',
          customClass: {
            popup: 'swal-wide'
          }
        });

      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: res.message
        });
      }
    }
  });
});

});
