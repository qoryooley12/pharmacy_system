<?php
include("../config/conn.php");

function fetchPatients($conn) {
    $sql = "SELECT id, patient_no, name, phone, gender, age, address, medical_conditions 
            FROM patient 
            ORDER BY id DESC";
    $result = $conn->query($sql);

    $patients = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
    }
    return json_encode($patients);
}

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header('Content-Type: application/json');
    echo fetchPatients($conn);
}
?>
