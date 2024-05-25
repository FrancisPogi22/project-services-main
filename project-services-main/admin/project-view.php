<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbcon.php');
include('modal/task-modal-add.php');
include('modal/productivity-add-modal.php');

// Fetch proj_id from URL parameter
$proj_id = isset($_GET['proj_id']) ? $_GET['proj_id'] : '';

$stmt = $con->prepare('SELECT project_progress FROM project WHERE id = ?');
$stmt->bind_param('i', $proj_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $project_progress = $row['project_progress'];
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Project View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Project View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-4">
        <?php
        $query = "SELECT project.*, categories.name AS category_name, customers.name AS customer_name 
          FROM project 
          LEFT JOIN categories ON project.category_id = categories.id
          LEFT JOIN customers ON project.customers_id = customers.id
          WHERE project.id = $proj_id";

        $query_run = mysqli_query($con, $query);

        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
        ?>

            <?php
            alertMessage();
            ?>
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Project Details
                        <!--<a href="productivity-list.php" class="btn btn-success float-right btn-sm"><i class="fas fa-eye"></i> View Productivity</a>-->
                        <button id="generatePdf" data-id="<?php echo $row['id']; ?>">Generate PDF</button>
                        <a href="project-index.php" class="btn btn-danger float-right mx-2 btn-sm">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?php echo "uploads_file/" . $row['image']; ?>" class="img-fluid" style="width: 600px; height: 500px;" alt="Project Plan">
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Category</th>
                                        <td><?php echo $row['category_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ProjectName</th>
                                        <td><?php echo $row['project_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Client Name</th>
                                        <td><?php echo $row['customer_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td><?php echo $row['description']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address</th>
                                        <td><?php echo $row['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Project Manager</th>
                                        <td>
                                            <?php
                                            // Fetch project manager's image from the database based on their name
                                            $project_manager_name = $row['position'];
                                            $manager_query = "SELECT * FROM employee WHERE name='$project_manager_name'";
                                            $manager_result = mysqli_query($con, $manager_query);

                                            if (mysqli_num_rows($manager_result) > 0) {
                                                $manager_row = mysqli_fetch_assoc($manager_result);
                                                $manager_image = $manager_row['image'];
                                                // Display project manager's image
                                                echo '<div style="display: flex; align-items: center;">';
                                                echo '<img src="uploads_emp/' . $manager_image . '" alt="Project Manager" class="rounded-circle" style="max-width: 50px; margin-right: 10px;">';
                                                echo '<span>' . $row['position'] . '</span>';
                                                echo '</div>';
                                            } else {
                                                echo 'No image available';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date Start</th>
                                        <td>
                                            <span style="position: relative;">
                                                <i class="fa fa-calendar"></i>
                                                <!-- Calendar Icon -->
                                                <?php echo date("F j, Y", strtotime($row['date_start'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Due Date</th>
                                        <td>
                                            <span style="position: relative;">
                                                <i class="fa fa-calendar" style=""></i>
                                                <!-- Calendar Icon -->
                                                <?php echo date("F j, Y", strtotime($row['due_date'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td>
                                            <?php
                                            $status = $row['status'];
                                            $badge_class = '';
                                            switch ($status) {
                                                case 0:
                                                    $badge_class = 'bg-primary'; // Pending
                                                    break;
                                                case 1:
                                                    $badge_class = 'bg-secondary'; // Preparing
                                                    break;
                                                case 2:
                                                    $badge_class = 'bg-warning'; // On-Progress
                                                    break;
                                                case 3:
                                                    $badge_class = 'bg-success'; // Completed
                                                    break;
                                                case 4:
                                                    $badge_class = 'bg-danger'; // Cancelled
                                                    break;
                                                default:
                                                    $badge_class = 'bg-secondary'; // Default
                                                    break;
                                            }
                                            echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Progress</th>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $project_progress ?>%" aria-valuenow="<?php echo $project_progress ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $project_progress ?>%</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        } else {
        ?>
            <div class="alert alert-warning mt-4" role="alert">
                No Record Found
            </div>
        <?php
        }
        ?>

        <!-- Task List Card -->



        <!-- Task View Modal -->
        <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewTaskModalLabel">Task View</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <!-- Task details will be loaded dynamically here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h5>Task List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Task Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Worker</th>
                                <th scope="col">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch only tasks associated with the current project
                            $task_query = "SELECT task.*, project.project_name AS project_name
                                        FROM task
                                        LEFT JOIN project ON task.project_id = project.id
                                        WHERE task.project_id = $proj_id";
                            $task_query_run = mysqli_query($con, $task_query);

                            if ($task_query_run) {
                                while ($row = mysqli_fetch_assoc($task_query_run)) {
                            ?>
                                    <tr>
                                        <!-- <td><?php echo $row['id']; ?></td> -->
                                        <td><?php echo $row['task_name']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td>
                                            <?php echo date("F j, Y | g:i A", strtotime($row['created_at'])); ?>
                                        </td>

                                        <td><?php
                                            $status = $row['status'];
                                            $badge_class = '';
                                            switch ($status) {
                                                case 0:
                                                    $badge_class = 'bg-primary'; // Pending
                                                    break;
                                                case 1:
                                                    $badge_class = 'bg-secondary'; // Preparing
                                                    break;
                                                case 2:
                                                    $badge_class = 'bg-warning'; // On-Progress
                                                    break;
                                                case 3:
                                                    $badge_class = 'bg-success'; // Completed
                                                    break;
                                                case 4:
                                                    $badge_class = 'bg-danger'; // Cancelled
                                                    break;
                                                default:
                                                    $badge_class = 'bg-secondary'; // Default
                                                    break;
                                            }
                                            echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                                            ?>
                                        </td>
                                        <td><?php echo $row['workers'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info view-task" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#viewTaskModal"><i class="fas fa-eye"></i> View</button>
                                            <button class="btn btn-sm btn-secondary" onclick="window.location.href='task-set-status.php?id=<?php echo $row['id']; ?>'"><i class="fas fa-edit"></i> Edit / Set Status</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- // Task List Card -->

        <?php
        // Get the project ID from the URL
        if (isset($_GET['proj_id'])) {
            $proj_id = $_GET['proj_id'];

            // Fetch data from the productivity table for the specified project
            $sql = "SELECT p.*, t.task_name 
            FROM productivity p
            LEFT JOIN task t ON p.task_id = t.id
            WHERE t.project_id = $proj_id";
            $result = $con->query($sql);
        }
        ?>

        <!-- Productivity Card Removed -->
    </div>
</div>

<?php
include('includes/script.php');
include('includes/footer.php');
?>
<script>
    $(document).ready(function() {
        document.getElementById('generatePdf').addEventListener('click', function() {
            fetch(`fetch_project_tasks.php?proj_id=${$(this).data('id')}`)
                .then(response => response.json())
                .then(data => {
                    const tasks = data.tasks;

                    const tableBody = [
                        [{
                            text: 'Material',
                            bold: true
                        }, {
                            text: 'Quantity',
                            bold: true
                        }, {
                            text: 'Cost',
                            bold: true
                        }]
                    ];

                    tasks.forEach(task => {
                        task.materials.forEach(material => {
                            let cost = parseFloat(material.cost);
                            tableBody.push([material.name, material.quantity, cost.toFixed(2)]);
                        });
                        tableBody.push([{
                            text: 'Total Cost',
                            colSpan: 2,
                            alignment: 'right'
                        }, {}, task.total_cost.toFixed(2)]);
                    });

                    let docDefinition = {
                        content: [{
                                text: "Project Name: " + data.project_name,
                                fontSize: 16,
                                bold: true,
                                margin: [0, 0, 0, 10]
                            },
                            {
                                text: "Task Included: " + data.name,
                                fontSize: 16,
                                bold: true,
                                margin: [0, 0, 0, 10]
                            },
                            {
                                text: 'Material Costing',
                                fontSize: 14,
                                bold: true,
                                margin: [0, 0, 0, 10]
                            },
                            {
                                table: {
                                    headerRows: 1,
                                    widths: ['*', '*', '*'],
                                    body: tableBody
                                }
                            }
                        ]
                    };

                    pdfMake.createPdf(docDefinition).open();
                });
        });


        $('.view-task').click(function(e) {
            e.preventDefault();
            var taskId = $(this).data('id');
            $.ajax({
                url: 'task-view.php',
                type: 'GET',
                data: {
                    id: taskId
                },
                success: function(response) {
                    $('#viewTaskModal .modal-body').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Reload page when modal is closed
        $('#viewTaskModal').on('hidden.bs.modal', function() {
            location.reload();
        });
    });
</script>

<?php
// Function to get status text based on status code
function getStatusText($status)
{
    switch ($status) {
        case 0:
            return 'Pending';
            break;
        case 1:
            return 'Preparing';
            break;
        case 2:
            return 'On-progress';
            break;
        case 3:
            return 'Completed';
            break;
        case 4:
            return 'Cancelled';
            break;
        default:
            return 'Unknown';
            break;
    }
}
?>

<?php
// Function to get Priority text based on priority code
function getPriorityText($priority)
{
    switch ($priority) {
        case 0:
            return 'Low';
            break;
        case 1:
            return 'Medium';
            break;
        case 2:
            return 'High';
            break;
        default:
            return 'Unknown';
            break;
    }
}
?>