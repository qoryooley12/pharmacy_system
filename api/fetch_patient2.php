<?php
include "../config/conn.php";

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $sql = "SELECT id, patient_no, name, phone, gender, age, address, medical_conditions
            FROM patient
            WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    header('Content-Type: application/json');
    echo json_encode($data);
}
