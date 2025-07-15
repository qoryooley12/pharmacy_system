
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lab Request Sheet</title>
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
      width: 200px;
      height: 200px;
    }
  </style>
</head>
<body>
<div class="page-wrapper">
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="p-4 bg-white border rounded shadow-sm">

        <!-- Form -->
 <form id="labForm">
  <div class="row mb-3">
    <div class="col-md-6">
      <label for="patientSelect" class="form-label">Select Patient:</label>
      <select class="form-select" id="patientSelect"></select>
    </div>
    <div class="col-md-6">
      <label for="doctorName" class="form-label">Doctor Name:</label>
      <input type="text" class="form-control" id="doctorName" placeholder="Enter doctor's name" />
    </div>
  </div>

  <div class="mb-4">
    <label class="form-label">Select Requested Tests:</label>
    <div class="row" id="testsCheckboxes"></div>
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-primary no-print">Generate & Print</button>
  </div>
</form>


        <!-- Printable Section -->
        <div id="printSection" class="mt-5 d-none">
          
          <!-- Pharmacy Header -->
          <div class="pharmacy-header">
            <!-- Using Font Awesome medical icon -->
            <i class="fas fa-heartbeat"></i>
            <span class="pharmacy-name">Deris Uroone Pharmacy and Medical Laboratory</span>
          </div>

          <div class="pharmacy-contact">
            Qoryooley - Somalia | Tel: +252615599345, +252613765455, +252617618145
          </div>

          <hr class="my-3" />

          <h3 class="text-center text-primary mb-4">Laboratory Request Sheet</h3>

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

          <h5 class="mb-2">Requested Tests:</h5>
          <ul class="list-group mb-4" id="printTestsList"></ul>

          <div class="text-center mt-4">
            <div id="qrcode"></div>
          </div>

          <div class="pharmacy-contact mt-4">
            Thanks for choosing Deris Uroone Pharmacy and Medical Laboratory.
          </div>
          
        </div>

      </div>
    </div>
  </div>
</div>
</div>

</body>
</html>
