<?php
header('Content-Type: application/json');
include("../config/conn.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if (function_exists($action)) {
        $action($conn);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ficilka la codsaday lama helin!' // Somali: The requested action was not found
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ficil lama sheegin!' // Somali: No action specified
    ]);
}

function generate_patient_no($conn) {
    $sql = "SELECT patient_no FROM patient ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $last_no = $row['patient_no'];
        $num = intval(substr($last_no, 4));
        $new_num = $num + 1;
    } else {
        $new_num = 1;
    }

    return "PAT-" . str_pad($new_num, 4, "0", STR_PAD_LEFT);
}

function insertF($conn) {
    $patient_no = generate_patient_no($conn);
    $name = mysqli_real_escape_string($conn, $_POST['patientName'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['patientPhone'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['patientGender'] ?? '');
    $age = intval($_POST['patientAge'] ?? 0);
    $address = mysqli_real_escape_string($conn, $_POST['patientAddress'] ?? '');
    $conditions = mysqli_real_escape_string($conn, $_POST['patientConditions'] ?? '');

    if (
        empty($patient_no) ||
        empty($name) ||
        empty($phone) ||
        empty($gender) ||
        empty($age) ||
        empty($address) ||
        empty($conditions)
    ) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Dhammaan xogaha waa in la buuxiyaa!' // Somali: All fields are required
        ]);
        return;
    }

    $sql = "INSERT INTO patient (patient_no, name, phone, gender, age, address, medical_conditions, created_at)
            VALUES ('$patient_no', '$name', '$phone', '$gender', $age, '$address', '$conditions', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Bukaan cusub waa lagu guuleystay in la diiwaan geliyo!',
            'patient_no' => $patient_no
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Qalad ayaa dhacay: ' . mysqli_error($conn)
        ]);
    }
}

function fetchAllPatients($conn) {
    $sql = "SELECT id, patient_no, name, phone, gender, age, address, medical_conditions, created_at FROM patient";
    $result = mysqli_query($conn, $sql);

    $patients = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $patients[] = $row;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $patients
    ]);
}

function fetchSinglePatient($conn) {
    $id = intval($_POST['id'] ?? 0);
    $sql = "SELECT * FROM patient WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bukaan lama helin!']);
    }
}


function updatePatient($conn) {
    $id = intval($_POST['id'] ?? 0);
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $conditions = mysqli_real_escape_string($conn, $_POST['medical_conditions'] ?? '');

    if (
        empty($id) ||
        empty($name) ||
        empty($phone) ||
        empty($gender) ||
        empty($age) ||
        empty($address) ||
        empty($conditions)
    ) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Dhammaan xogaha waa in la buuxiyaa!' // All fields are required
        ]);
        return;
    }

    $sql = "UPDATE patient 
            SET 
                name = '$name',
                phone = '$phone',
                gender = '$gender',
                age = $age,
                address = '$address',
                medical_conditions = '$conditions'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Bukaan waa la cusboonaysiiyay!' // Patient updated successfully
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Qalad ayaa dhacay: ' . mysqli_error($conn) // An error occurred
        ]);
    }
}





function deletePatient($conn) {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID sax ah lama helin!'
        ]);
        return;
    }

    // optional: check if patient exists
    $check = mysqli_query($conn, "SELECT * FROM patient WHERE id = $id LIMIT 1");
    if (!$check || mysqli_num_rows($check) == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Bukaanka lama helin!'
        ]);
        return;
    }

    $sql = "DELETE FROM patient WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Bukaanka si guul leh ayaa loo tirtiyay!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Tirtiriddu waa ku guuldareysatay: ' . mysqli_error($conn)
        ]);
    }
}



function deleteAllPatients($conn) {
    // Fetch all patients first
    $sql = "SELECT * FROM patient";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Insert each patient into patients_trash
            $insertSQL = "INSERT INTO patients_trash
                (patient_no, name, phone, gender, age, address, medical_conditions)
                VALUES (
                    '".mysqli_real_escape_string($conn, $row['patient_no'])."',
                    '".mysqli_real_escape_string($conn, $row['name'])."',
                    '".mysqli_real_escape_string($conn, $row['phone'])."',
                    '".mysqli_real_escape_string($conn, $row['gender'])."',
                    ".intval($row['age']).",
                    '".mysqli_real_escape_string($conn, $row['address'])."',
                    '".mysqli_real_escape_string($conn, $row['medical_conditions'])."'
                )";
            mysqli_query($conn, $insertSQL);
        }

        // Delete all patients from original table
        $deleteSQL = "DELETE FROM patient";
        if (mysqli_query($conn, $deleteSQL)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Bukaannada oo dhan waa la raray oo la tirtiray!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tirtirka wuu guuldareystay: ' . mysqli_error($conn)
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ma jiro bukaan la tirtiri karo.'
        ]);
    }
}



function fetchAllDeletedPatients($conn) {
    $sql = "SELECT * FROM patients_trash ORDER BY deleted_at DESC";
    $result = mysqli_query($conn, $sql);
    $patients = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $patients[] = $row;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $patients
    ]);
}



?>