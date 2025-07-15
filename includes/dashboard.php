<?php
include("../config/conn.php");
include_once '../auth/auth.php';

// Count total patients
$sql = "SELECT COUNT(*) AS total_patients FROM patient";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Count lab requests
$sql2 = "SELECT COUNT(*) AS total_request FROM lab_requests";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

// Count male and female patients
$sql3 = "
    SELECT 
        SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS total_male,
        SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS total_female
    FROM patient
";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();



// Fetch latest 5 patients
$sql_patients = "
    SELECT id, name, address 
    FROM patient 
    ORDER BY id DESC 
    LIMIT 8
";
$result_patients = $conn->query($sql_patients);

$latest_patients = [];
if ($result_patients) {
    while ($pat = $result_patients->fetch_assoc()) {
        $latest_patients[] = $pat;
    }
}


?>


<div class="page-wrapper">
   <div class="content mb-2">
    <div class="alert alert-primary d-flex align-items-center justify-content-between shadow-sm rounded p-4 mb-4">
  <div class="d-flex align-items-center">
    <i class="bi bi-person-circle fs-1 text-primary me-3"></i>
    <div>
      <h4 class="mb-0 fw-bold">Salaam Dr. <?php echo htmlspecialchars($_SESSION['user']['name']); ?></h4>
      <small class="text-muted">Welcome to your dashboard</small>
    </div>
  </div>
  <span class="badge bg-success rounded-pill px-3 py-2">Online</span>
</div>
    <div class="row">
      
      <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count">
          <div class="dash-counts">
            <h4><?php echo $row['total_patients']; ?></h4>
            <h5>Patients</h5>
          </div>
          <div class="dash-imgs">
            <i data-feather="user"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-sm-6 col-12 d-flex">
  <div class="dash-count das1">
    <div class="dash-counts">
      <h4><?php echo $row3['total_male']; ?></h4>
      <h5>Male Patients</h5>
    </div>
    <div class="dash-imgs">
      <i data-feather="user-check"></i>
    </div>
  </div>
</div>

<div class="col-lg-3 col-sm-6 col-12 d-flex">
  <div class="dash-count das2">
    <div class="dash-counts">
      <h4><?php echo $row3['total_female']; ?></h4>
      <h5>Female Patients</h5>
    </div>
    <div class="dash-imgs">
      <i data-feather="user"></i>
    </div>
  </div>
</div>


      <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das3">
          <div class="dash-counts">
            <h4><?php echo $row2['total_request']; ?></h4>
            <h5>Lab Tests</h5>
          </div>
          <div class="dash-imgs">
            <i data-feather="activity"></i>
          </div>
        </div>
      </div>
    </div>
 


    <div class="row">
      <div class="col-lg-7 col-sm-12 col-12 d-flex">
        <div class="card flex-fill">
          <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Pharmacy Purchases & Sales</h5>
            <div class="graph-sets">
              <ul>
                <li>
                  <span>Sales</span>
                </li>
                <li>
                  <span>Purchases</span>
                </li>
              </ul>
              <div class="dropdown">
                <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  2025 <img src="../assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a href="javascript:void(0);" class="dropdown-item">2025</a></li>
                  <li><a href="javascript:void(0);" class="dropdown-item">2024</a></li>
                  <li><a href="javascript:void(0);" class="dropdown-item">2023</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="sales_charts"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-sm-12 col-12 d-flex">
  <div class="card flex-fill">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <h4 class="card-title mb-0">Recently Added Patients</h4>
      <div class="dropdown">
        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
          <i class="fa fa-ellipsis-v"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li>
            <a href="patientlist.html" class="dropdown-item">Patient List</a>
          </li>
          <li>
            <a href="addpatient.html" class="dropdown-item">Add Patient</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive dataview">
        <table class="table datatable">
          <thead>
            <tr>
              <th>Sno</th>
              <th>Patient Name</th>
              <th>Address</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($latest_patients as $index => $pat): ?>
              <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($pat['name']); ?></td>
                <td><?php echo htmlspecialchars($pat['address']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

    </div>

    <div class="card mb-0">
  <div class="card-body">
    <h4 class="card-title">Latest Lab Requests</h4>
    <div class="table-responsive dataview">
      <table class="table datatable" id="labRequestsTable">
        <thead>
          <tr>
            <th>Request ID</th>
            <th>Patient Name</th>
            <th>Doctor Name</th>
            <th>Requested Tests</th>
            <th>Request Date</th>
          </tr>
        </thead>
        <tbody>
          <!-- rows will be inserted here via JS -->
        </tbody>
      </table>
    </div>
  </div>
</div>

 </div>
</div>
 
