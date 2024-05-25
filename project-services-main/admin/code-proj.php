<?php
include 'authentication.php';
include 'config/dbcon.php';
include 'config/function.php';

// Insert Equipment
if (isset($_POST['saveEquipment'])) {
    $name = $_POST['name'] ?? '';
    $value = $_POST['value'] ?? '';
    $note = $_POST['description'] ?? ''; // Assuming the textarea for note has name="description"
    $status = $_POST['status'] ?? '0'; // Default status is 'available'
    $image = $_FILES['image']['name'] ?? '';

    if (file_exists("uploads/" . $_FILES['image']['name'])) {
        $filename = $_FILES['image']['name'];
        $_SESSION['status'] = $filename . " Image already exists";
        header('location: equipment-create.php');
    } else {
        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // SQL query with corrected column names
        $insert_equipment_query = "INSERT INTO equipment (name, value, note, status, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_equipment_query);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $value, $note, $status, $image);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['status'] = "Equipment Added Successfully";
            header('location: equipment-create.php');
        } else {
            $_SESSION['status'] = "Equipment Insertion Failed";
            header('location: equipment.php');
        }
    }
}

// Update Equipment
if (isset($_POST['updateEquipment'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $value = $_POST['value'] ?? '';
    $note = $_POST['note'] ?? '';
    $status = $_POST['status'] ?? '';
    $image_old = $_POST['image_old'] ?? '';
    $image = $_FILES['image']['name'] ?? '';

    // File upload handling
    if ($image !== '') {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Check if the new image file already exists
        if (file_exists($target_file)) {
            $_SESSION['status'] = "Sorry, file already exists.";
            header('location: equipment-edit.php?id=' . $id);
            exit;
        }

        // Upload new image
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        // If no new image is uploaded, use the old one
        $image = $image_old;
    }

    // SQL injection prevention with prepared statements
    $update_equipment_query = "UPDATE equipment SET name=?, value=?, note=?, status=?, image=? WHERE id=?";
    $stmt = mysqli_prepare($con, $update_equipment_query);
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $value, $note, $status, $image, $id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Equipment Updated Successfully";
        header('location: equipment.php');
    } else {
        $_SESSION['status'] = "Equipment Update Failed";
        header('location: equipment.php');
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Delete Equipment
if (isset($_POST['deleteEquipment'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];

    $delete_query = "DELETE FROM equipment WHERE id='$id' ";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        // Delete image file
        if (unlink("uploads/" . $image)) {
            $_SESSION['status'] = "Equipment Deleted Successfully";
            header('location: equipment.php');
        } else {
            $_SESSION['status'] = "Failed to delete image file";
            header('location: equipment.php');
        }
    } else {
        $_SESSION['status'] = "Failed to delete equipment";
        header('location: equipment.php');
    }
}

// Insert New Employee
if (isset($_POST['saveEmployee'])) {
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $address = $_POST['address'] ?? '';
    $position = $_POST['position'] ?? '';
    $status = $_POST['status'] ?? '0'; // Default status is 'available'
    $image = $_FILES['image']['name'] ?? '';

    if (file_exists("uploads_emp/" . $_FILES['image']['name'])) {
        $filename = $_FILES['image']['name'];
        $_SESSION['status'] = $filename . " Image already exists";
        header('location: employee-create.php');
    } else {
        // File upload handling
        $target_dir = "uploads_emp/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // SQL query for inserting employee
        $insert_employee_query = "INSERT INTO employee (name, age, email, contact, address, position, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_employee_query);

        // Bind parameters to prepared statement
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $age, $email, $contact, $address, $position, $status, $image);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['status'] = "New Employee Added Successfully";
            header('location: employee-create.php');
        } else {
            $_SESSION['status'] = "Employee Insertion Failed";
            header('location: employee-create.php');
        }
    }
}

// Update Employee
if (isset($_POST['updateEmployee'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $address = $_POST['address'] ?? '';
    $position = $_POST['position'] ?? '';
    $status = $_POST['status'] ?? '0'; // Default status is 'available'
    $image = $_FILES['image']['name'] ?? '';
    $image_old = ''; // Define $image_old variable

    // File upload handling
    if ($image !== '') {
        $target_dir = "uploads_emp/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Check if the new image file already exists
        if (file_exists($target_file)) {
            $_SESSION['status'] = "Sorry, file already exists.";
            header('location: employee-edit.php?id=' . $id);
            exit;
        }

        // Upload new image
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Update the image name
        $image_old = $image; // Update $image_old with the new image name
    } else {
        // If no new image is uploaded, use the old one
        $image_old = $_POST['image_old']; // or whatever default value you want to use
    }

    // SQL injection prevention with prepared statements
    $update_employee_query = "UPDATE employee SET name=?, age=?, email=?, contact=?, address=?, position=?, status=?, image=? WHERE id=?";
    $stmt = mysqli_prepare($con, $update_employee_query);
    mysqli_stmt_bind_param($stmt, "ssssssisi", $name, $age, $email, $contact, $address, $position, $status, $image_old, $id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Employee Updated Successfully";
        header('location: employee.php');
    } else {
        $_SESSION['status'] = "Employee Update Failed";
        header('location: employee.php');
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Delete Employee
if (isset($_POST['deleteEmployee'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];

    $delete_query = "DELETE FROM employee WHERE id=?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $delete_query_run = mysqli_stmt_execute($stmt);

    if ($delete_query_run) {
        // Delete image file
        if (unlink("uploads_emp/" . $image)) {
            $_SESSION['status'] = "Employee Deleted Successfully";
            header('location: employee.php');
        } else {
            $_SESSION['status'] = "Failed to delete file";
            header('location: employee.php');
        }
    } else {
        $_SESSION['status'] = "Failed to delete Employee";
        header('location: employee.php');
    }
}

if (isset($_POST['saveProject'])) {
    $total_task = validate($_POST['total_task']);
    $category_id = validate($_POST['category_id']);
    $project_name = validate($_POST['project_name']);
    $customers_id = validate($_POST['customers_id']);
    $description = validate($_POST['description']);
    $address = validate($_POST['address']);
    $position = validate($_POST['position']);
    $date_start = validate($_POST['date_start']);
    $due_date = validate($_POST['due_date']);
    $status = $_POST['status'] ?? '0';
    $image = $_FILES['image']['name'];

    if (file_exists("uploads_file/" . $_FILES['image']['name'])) {
        $filename = $_FILES['image']['name'];
        $_SESSION['status'] = $filename . " Image already exists";
        header('location: project-index.php');
    } else {
        $insert_image_query = "INSERT INTO project(category_id,project_name,customers_id,description,address,position,image,date_start,due_date,status,project_num_task) 
                                VALUES ('$category_id','$project_name', '$customers_id','$description','$address','$position','$image','$date_start','$due_date','$status', '$total_task')";
        $insert_image_query_run = mysqli_query($con, $insert_image_query);

        if ($insert_image_query_run) {
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads_file/" . $_FILES['image']['name']);
            $_SESSION['status'] = $current_id;
            header('location: project-index.php');
        } else {
            $_SESSION['status'] = $current_id;
            header('location: project-index.php');
        }
    }
}

if (isset($_POST['updateProject'])) {
    $proj_id = $_POST['id'];
    $category_id = $_POST['category_id'];
    $project_name = $_POST['project_name'];
    $customers_id = $_POST['customers_id'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $position = $_POST['project_manager']; // Corrected variable name
    $date_start = $_POST['date_start'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'] ?? '0'; // Default status is '0'

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['image_old'];

    if ($new_image != '') {
        // Move the new image file to the uploads directory
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads_file/" . $_FILES['image']['name']);
        // Delete the existing image file
        unlink("uploads_file/" . $old_image);
        $update_project = $new_image;
    } else {
        $update_project = $old_image;
    }

    $update_project_query = "UPDATE project SET 
    category_id='$category_id',
    project_name='$project_name',
    customers_id='$customers_id',
    description='$description',
    address='$address',
    position='$position',
    date_start='$date_start',
    due_date='$due_date',
    status='$status'";

    if ($update_project != $old_image) {
        $update_project_query .= ", image='$update_project'";
    }

    $update_project_query .= " WHERE id='$proj_id' ";

    $update_project_query = mysqli_query($con, $update_project_query);

    if ($update_project_query) {
        $_SESSION['status'] = "Project Update Successfully";
        header('location: project-index.php');
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        header('location: project-edit.php');
    }
}

if (isset($_POST['deleteProject'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];

    $delete_project_query = "DELETE FROM project WHERE id='$id' ";
    $delete_project_query_run = mysqli_query($con, $delete_project_query);

    if ($delete_project_query_run) {
        unlink("uploads_file/" . $image);
        $_SESSION['status'] = "Project Deleted Successfully";
        header('location: project-index.php');
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        header('location: project-index.php');
    }
}

if (isset($_POST['archiveProject'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];

    $archive_project_query = "UPDATE project SET status = 4 WHERE id='$id' ";
    $archive_project_query_run = mysqli_query($con, $archive_project_query);

    if ($archive_project_query_run) {
        unlink("uploads_file/" . $image);
        $_SESSION['status'] = "Project Archvied Successfully";
        header('location: project-index.php');
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        header('location: project-index.php');
    }
}

if (isset($_POST['saveTask'])) {
    $project_id = $_POST['project_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'] ?? '0'; // Default status is '0'
    $priority = $_POST['priority'] ?? '0'; // Default status is '0'

    $query = "INSERT INTO task (project_id, task_name, description, start_date, due_date, status, priority) VALUES ('$project_id', '$task_name', '$description', '$start_date', '$due_date', '$status', '$priority')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Task Added Successfully";
        // Redirect to project view page with the specified project ID
        header("location: http://localhost/project-services/admin/project-view.php?proj_id=$project_id");
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        header('location: project-index.php');
    }
}

if (isset($_POST['updateTask'])) {
    $task_id = $_POST['task_id'];

    $project_id = $_POST['project_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'] ?? '0'; // Default status is '0'
    $priority = $_POST['priority'] ?? '0'; // Default status is '0'

    $query = "UPDATE task SET project_id='$project_id', task_name='$task_name', description='$description', start_date='$start_date', due_date='$due_date', status='$status', priority='$priority' 
            WHERE id='$task_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Task Updated Successfully";
        header('location: task-list.php');
        exit(0);
    } else {
        $_SESSION['status'] = "Something Went Wrong!";
        header('location: task-list.php');
        exit(0);
    }
}

if (isset($_POST['taskDelete'])) {
    $task_id = $_POST['taskDelete'];

    // Retrieve project ID associated with the task
    $query = "SELECT project_id FROM task WHERE id = $task_id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $project_id = $row['project_id'];

        // Begin transaction
        mysqli_autocommit($con, false);

        // Delete the task
        $delete_query = "DELETE FROM task WHERE id = $task_id";
        $delete_result = mysqli_query($con, $delete_query);

        // Check if task is deleted successfully
        if ($delete_result) {
            // Update status of all tasks associated with the project to 'Cancelled'
            $update_query = "UPDATE task SET status = 4 WHERE project_id = $project_id";
            $update_result = mysqli_query($con, $update_query);

            if ($update_result) {
                // Commit transaction
                mysqli_commit($con);
                $_SESSION['status'] = "Task Deleted Successfully";
                header('Location: task-list.php');
                exit();
            } else {
                // Rollback transaction if update fails
                mysqli_rollback($con);
                $_SESSION['status'] = "Failed to update task status.";
                header('Location: task-list.php');
                exit();
            }
        } else {
            // Rollback transaction if delete fails
            mysqli_rollback($con);
            $_SESSION['status'] = "Failed to delete task.";
            header('Location: task-list.php');
            exit();
        }
    } else {
        // Handle project id retrieval failure
        $_SESSION['status'] = "Failed to retrieve project id.";
        header('Location: task-list.php');
        exit();
    }
}

if (isset($_POST['saveProductivity'])) {
    // Check form data
    print_r($_POST);

    $project_id = $_POST['project_id'];
    $task_id = $_POST['task_id'];
    $description = $_POST['description'];
    $start_duration = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_duration = isset($_POST['due_date']) ? $_POST['due_date'] : '';
    $priority = isset($_POST['priority']) ? $_POST['priority'] : '0'; // Default priority is '0'
    $status = isset($_POST['status']) ? $_POST['status'] : '0'; // Default status is '0'

    // Handle employee data
    $employee_array = isset($_POST['employee']) ? $_POST['employee'] : array();
    $employees = '';
    foreach ($employee_array as $employee) {
        $employee_data = explode('|', $employee);
        $employees .= $employee_data[0] . ' (' . $employee_data[1] . '), ';
    }
    $employee = rtrim($employees, ', ');

    $equipment_name = isset($_POST['equipment']) ? $_POST['equipment'] : array();
    $material_name = isset($_POST['material']) ? $_POST['material'] : array();

    // Implode arrays to convert them into comma-separated strings
    $equipment = implode(', ', $equipment_name);
    $material = implode(', ', $material_name);

    // Prepare and execute the INSERT statement
    $query = "INSERT INTO productivity (task_id, description, start_duration, end_duration, status, priority, employee, equipment, material) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issssisss", $task_id, $description, $start_duration, $end_duration, $status, $priority, $employee, $equipment, $material);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            $_SESSION['status'] = "Productivity Added Successfully";
            header("location: project-index.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Error: " . mysqli_error($con); // Check for MySQL errors
            header("location: project-index.php?proj_id=" . $project_id);
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Error: " . mysqli_error($con); // Check for MySQL errors
        header("location: project-index.php?proj_id=" . $project_id);
        exit(0);
    }
}

if (isset($_POST['updateProductivity'])) {
}
