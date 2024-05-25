<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskMax = "SELECT id FROM task ORDER BY id DESC LIMIT 1";
    $taskIdResult = $con->query($taskMax);
    $current_task_id = 0;

    if ($taskIdResult && $taskIdResult->num_rows > 0) {
        $row = $taskIdResult->fetch_assoc();
        $current_task_id = $row['id'] + 1;
    }

    $query = "SELECT id FROM project ORDER BY id DESC LIMIT 1";
    $idResult = $con->query($query);
    $current_id = 0;

    if ($idResult && $idResult->num_rows > 0) {
        $row = $idResult->fetch_assoc();
        $current_id = $row['id'] + 1;
    }

    $task_name = $_POST['task_name'] ?? '';
    $task_description = $_POST['task_description'] ?? '';
    $equipment = $_POST['equipment'] ?? '';
    $task_start_date = $_POST['task_start_date'] ?? '';
    $task_due_date = $_POST['task_due_date'] ?? '';
    $task_priority = $_POST['task_priority'] ?? '';
    $task_status = $_POST['task_status'] ?? '';
    $totalPrice = $_POST['totalPrice'] ?? '';

    $selected_workers = isset($_POST['selected_workers']) ? $_POST['selected_workers'] : array();
    $selected_workers_str = implode(",", $selected_workers);

    $material_names_query = "SELECT name FROM products";
    $material_names_result = $con->query($material_names_query);
    $material_names = [];

    while ($row = $material_names_result->fetch_assoc()) {
        $material_names[] = $row['name'];
    }

    $materials_used = [];

    foreach ($_POST as $field_name => $value) {
        if (in_array($field_name, $material_names)) {
            $material_name = $con->real_escape_string($field_name);
            $quantity = $con->real_escape_string($value);

            $materials_used[] = $material_name;

            $update_query = "UPDATE products SET quantity = quantity - $quantity WHERE name = '$material_name'";
            $con->query($update_query);
        }
    }

    $materials_used_str = implode(", ", $materials_used);

    $selected_equipment = isset($_POST['selected_equipment']) ? $_POST['selected_equipment'] : array();
    $selected_equipment_str = implode(",", $selected_equipment);

    $task_sql = "INSERT INTO task (id, project_id, task_name, description, start_date, workers, materials, equipments, due_date, status, priority,cost)
                     VALUES ('$current_task_id', '$current_id', '$task_name', '$task_description', '$task_start_date', '$selected_workers_str', '$materials_used_str', '$selected_equipment_str', '$task_due_date', '$task_status', '$task_priority', $totalPrice)";

    if ($con->query($task_sql) === TRUE) {
        $response = [
            'status' => 'success',
            'message' => 'Form data processed successfully',
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error: ' . $con->error,
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}

$con->close();
