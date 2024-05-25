<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbcon.php');

// Fetch the uploaded project from the database with category names and customer names
$sql = "SELECT
project.*,
categories.name AS category_name,
customers.name AS customer_name
FROM
project
JOIN categories ON project.category_id = categories.id
LEFT JOIN customers ON project.customers_id = customers.id
WHERE
project.status != 4";
$result = mysqli_query($con, $sql);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card">

        <?php
        alertMessage();
        ?>

        <div class="card-header">
            <h4>Project Files
                <a href="project-create.php" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus-circle"></i> Create Project</a>
            </h4>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Project Name</th>
                        <th>Project Category</th>
                        <th>Project Manager</th>
                        <th>Client Name</th>
                        <th>Date & Time Created</th>
                        <th>Status</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <!-- <td><?php echo $row['id']; ?></td> -->
                            <td><?php echo $row['project_name']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['position']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo date('j M Y | g:i A', strtotime($row['time_created'])); ?></td>
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
                                        $badge_class = 'bg-info'; // Default
                                        break;
                                }
                                echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                                ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Project Actions">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <button type="button" class="dropdown-item" onclick="viewProject('<?php echo $row['id'] ?>')">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            <button type="button" class="dropdown-item" onclick="editProject('<?php echo $row['id']; ?>')">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="code-proj.php" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                                                <button type="submit" name="archiveProject" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> Archive
                                                </button>
                                            </form>
                                            <form action="code-proj.php" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                                                <button type="submit" name="deleteProject" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('includes/script.php'); ?>

    <script>
        function viewProject(projId) {
            window.location.href = 'project-view.php?proj_id=' + projId;
        }

        function editProject(projId) {
            window.location.href = 'project-edit.php?proj_id=' + projId;
        }
    </script>

    <?php include('includes/footer.php'); ?>

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
                return 'On-Progress';
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