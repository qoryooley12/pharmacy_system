$(document).ready(function() {
  $.ajax({
    url: '../api/get_latest_lab_requests.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      let rows = "";
      data.forEach((item, index) => {
        rows += `
          <tr>
            <td>${item.request_id}</td>
            <td>${item.patient_name}</td>
            <td>${item.doctor_name}</td>
            <td>${item.requested_tests}</td>
            <td>${item.request_date}</td>
          </tr>
        `;
      });
      $("#labRequestsTable tbody").html(rows);
    }
  });
});