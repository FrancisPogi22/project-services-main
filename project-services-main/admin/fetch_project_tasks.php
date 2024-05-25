<?php
header('Content-Type: application/json');

include('config/dbcon.php');

$proj_id = $_GET['proj_id'];

$task_query = "SELECT task.*, project.project_name AS project_name
               FROM task
               LEFT JOIN project ON task.project_id = project.id
               WHERE task.project_id = $proj_id";
$task_result = mysqli_query($con, $task_query);

$project_name = '';
$name = '';
$tasks = [];

while ($task_row = mysqli_fetch_assoc($task_result)) {
    if (empty($project_name)) {
        $project_name = $task_row['project_name'];
    }

    if (empty($name)) {
        $name = $task_row['task_name'];
    }

    $materials = explode(', ', $task_row['materials']);
    $task_costs = [];

    foreach ($materials as $material) {
        // Fetch material price from the products table
        $product_query = "SELECT price FROM products WHERE name = '$material'";
        $product_result = mysqli_query($con, $product_query);

        if ($product_row = mysqli_fetch_assoc($product_result)) {
            $task_costs[] = [
                'name' => $material,
                'quantity' => 1,
                'cost' => $product_row['price']
            ];
        }
    }

    $tasks[] = [
        'task_name' => $task_row['task_name'],
        'materials' => $task_costs,
        'total_cost' => array_sum(array_column($task_costs, 'cost'))
    ];
}

echo json_encode([
    'name' => $name,
    'project_name' => $project_name,
    'tasks' => $tasks
]);

mysqli_close($con);
