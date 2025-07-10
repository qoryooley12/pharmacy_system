<?php
include "../config/conn.php";

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "SELECT patient_no, name, age, gender FROM patient WHERE id = $id LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
}
