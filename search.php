<?php
include 'db.php';
header('Content-Type: application/json');

$reg_no = $_GET['reg_no'] ?? '';

if ($reg_no) {
    // Select all columns (id, reg_no, hall_no, block_no, seat_no)
    $stmt = $conn->prepare("SELECT * FROM seats WHERE reg_no = ?");
    $stmt->bind_param("s", $reg_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Return JSON
        echo json_encode(["status" => "found", "data" => $row]);
    } else {
        echo json_encode(["status" => "not_found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No input"]);
}
?>