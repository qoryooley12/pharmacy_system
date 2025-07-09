<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"];
    $doctor = $_POST["doctor"];
    $tests = $_POST["tests"];

    $tests_str = implode(", ", $tests);
    $date = date("Y-m-d");

    $sql = "INSERT INTO lab_requests (patient_id, doctor_name, requested_tests, request_date)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $patient_id, $doctor, $tests_str, $date);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Lab request saved"]);
    } else {
        echo json_encode(["success" => false, "message" => $conn->error]);
    }
}
?>
