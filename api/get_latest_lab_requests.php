<?php
include("../config/conn.php");

$sql = "
    SELECT 
        lr.id AS request_id,
        p.name AS patient_name,
        lr.doctor_name,
        lr.requested_tests,
        lr.request_date
    FROM lab_requests lr
    JOIN patient p ON lr.patient_id = p.id
    ORDER BY lr.id DESC
    LIMIT 10
";

$result = $conn->query($sql);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>
