<div class="page-wrapper">
<div class="content container-fluid">
<div class="container my-2">
    <div class="card p-2">
      <div class="card-header">
      <h2 class="mb-4">Patient History</h2>
      </div>

   <table id="historyTable" class="table table-striped table-bordered">
  <thead class="table-primary text-white">
    <tr>
      <th>Patient No</th>
      <th>Name</th>
      <th>Date</th>
      <th>Condition</th>
      <th>Treatment</th>
      <th>Doctor</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>PAT-0001</td>
      <td>Norman Ryan</td>
      <td>2025-07-08</td>
      <td>Dental Check-up</td>
      <td>Routine cleaning</td>
      <td>Dr. Smith</td>
      <td><span class="badge bg-success">Completed</span></td>
    </tr>
    <tr>
      <td>PAT-0002</td>
      <td>Mohamed Ali</td>
      <td>2025-07-05</td>
      <td>Physical Exam</td>
      <td>Blood Tests</td>
      <td>Dr. Ahmed</td>
      <td><span class="badge bg-warning text-dark">Ongoing</span></td>
    </tr>
    <tr>
      <td>PAT-0003</td>
      <td>Fatima Noor</td>
      <td>2025-06-28</td>
      <td>Eye Check</td>
      <td>Prescription Glasses</td>
      <td>Dr. Lee</td>
      <td><span class="badge bg-success">Completed</span></td>
    </tr>
  </tbody>
</table>

    </div>
    
  </div>

</div>
</div>
  <script>
    $(document).ready(function () {

      // Example dummy data
      let historyData = [
        {
          patient_no: "PAT-0001",
          name: "Norman Ryan",
          date: "2025-07-08",
          condition: "Dental Check-up",
          treatment: "Routine cleaning",
          doctor: "Dr. Smith",
          status: "Completed"
        },
        {
          patient_no: "PAT-0002",
          name: "Mohamed Ali",
          date: "2025-07-06",
          condition: "Physical Exam",
          treatment: "Blood tests",
          doctor: "Dr. Ahmed",
          status: "Ongoing"
        }
      ];

      let rows = "";
      historyData.forEach(p => {
        rows += `
          <tr>
            <td>${p.patient_no}</td>
            <td>${p.name}</td>
            <td>${p.date}</td>
            <td>${p.condition}</td>
            <td>${p.treatment}</td>
            <td>${p.doctor}</td>
            <td>
              <span class="badge ${p.status === "Completed" ? "bg-success" : "bg-warning"}">
                ${p.status}
              </span>
            </td>
          </tr>
        `;
      });

      $("#historyTable tbody").html(rows);

      // Initialize DataTable
      $("#historyTable").DataTable({
        responsive: true
      });
    });
  </script>
