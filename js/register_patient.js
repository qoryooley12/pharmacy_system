$(document).ready(function () {

  // submit form
  $(document).on("submit", "#PatientForm", function(e) {
    e.preventDefault();

    let formdata = new FormData(this);
    formdata.append("action","insertF");

    $.ajax({
      type: "POST",
      url: "../api/patient_api.php",
      data: formdata,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if(response.status == "success"){
          Swal.fire({
            title: "Good job!",
            text: "Patient saved with ID: " + response.patient_no,
            icon: "success"
          }).then(() => {
            $("#addPatientModal").modal("hide");
            $("#PatientForm")[0].reset();
            reload();
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: response.message,
            icon: "error"
          });
        }
      }
    });
  });

  // load table
  reload();

      // reload function
    function reload() {
      $.ajax({
        type: "POST",
        url: "../api/patient_api.php",
        data: { action: "fetchAllPatients" },
        dataType: "json",
        success: function (response) {
          if(response.status === "success") {
            let rows = "";

            response.data.forEach(patient => {
              rows += `
                <tr>
                  <td>${patient.patient_no}</td>
                  <td>${patient.name}</td>
                  <td>${patient.phone}</td>
                  <td>
                    <button 
                      class="btn btn-sm btn-info rounded-circle view-btn" 
                      data-id="${patient.id}">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning rounded-circle">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger rounded-circle">
                        <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              `;
            });

            $("#tBody").html(rows);

            // destroy existing DataTable first if exists
            if ($.fn.DataTable.isDataTable('#patientTable')) {
              $('#patientTable').DataTable().destroy();
            }

            // re-initialize
            $('#patientTable').DataTable({
              responsive: true
            });

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

    // view more click
    $(document).on("click", ".view-btn", function() {
      let id = $(this).data("id");

      $.ajax({
        type: "POST",
        url: "../api/patient_api.php",
        data: { action: "fetchSinglePatient", id: id },
        dataType: "json",
        success: function (res) {
          if(res.status === "success") {
            let p = res.data;
            Swal.fire({
              title: `Macluumaadka: ${p.name}`,
              html: `
              <table class="table table-bordered table-sm">
                <tbody>
                  <tr>
                    <th>Patient No</th>
                    <td>${p.patient_no}</td>
                  </tr>
                  <tr>
                    <th>Magaca</th>
                    <td>${p.name}</td>
                  </tr>
                  <tr>
                    <th>Telefoon</th>
                    <td>${p.phone}</td>
                  </tr>
                  <tr>
                    <th>Jinsiga</th>
                    <td>${p.gender}</td>
                  </tr>
                  <tr>
                    <th>Da'da</th>
                    <td>${p.age}</td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td>${p.address}</td>
                  </tr>
                  <tr>
                    <th>Conditions</th>
                    <td>${p.medical_conditions}</td>
                  </tr>
                  <tr>
                    <th>created data</th>
                    <td>${p.medical_conditions}</td>
                  </tr>
                </tbody>
              </table>
            `,
              icon: "info"
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

$(document).ready(function () {

  // dummy data to demonstrate
  let patients = [
    // { name: "Abdullahi Hassan", phone: "0612345678" },
    // { name: "Mohamed Ali", phone: "0619876543" },
    // { name: "Fadumo Osman", phone: "0614567890" },
    // { name: "Salma Noor", phone: "0611122334" },
  ];

  function renderPatients(data) {
    let html = "";

    data.forEach(p => {
      let initials = p.name.slice(0,2).toUpperCase();

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

  renderPatients(patients);

  // Live search
  $("#searchPatient").on("keyup", function() {
    let keyword = $(this).val().toLowerCase();

    let filtered = patients.filter(p => 
      p.name.toLowerCase().includes(keyword) ||
      p.phone.includes(keyword)
    );

    renderPatients(filtered);
  });

  $.ajax({
  type: "POST",
  url: "../api/patient_api.php",
  data: { action: "fetchAllPatients" },
  dataType: "json",
  success: function (response) {
    if (response.status === "success") {
      renderPatients(response.data);
    }
  }
});

});
