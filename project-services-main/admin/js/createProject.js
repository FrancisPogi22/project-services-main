$("document").ready(function () {
  let createdTasks = [];
  let num_task;

  function formatDate(dateString) {
    var date = new Date(dateString);

    var monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];

    var month = monthNames[date.getMonth()];
    var day = date.getDate();
    var year = date.getFullYear();
    var hour = date.getHours();
    var minute = date.getMinutes();

    var amPm = hour >= 12 ? "PM" : "AM";
    hour = hour % 12 || 12;

    var formattedDate =
      month +
      " " +
      day +
      ", " +
      year +
      " | " +
      hour +
      ":" +
      (minute < 10 ? "0" : "") +
      minute +
      " " +
      amPm;

    return formattedDate;
  }

  // $('#projectFormCreate').submit(function(event) {
  //     event.preventDefault();

  //     var formData = new FormData(this);
  //     formData.append('num_task', num_task);

  //     $.ajax({
  //         type: 'POST',
  //         url: './php/project_save.php',
  //         data: formData,
  //         processData: false,
  //         contentType: false,
  //         success: function(response) {
  //             console.log(response);
  //             if (response === '0') {
  //                 insertTask();
  //             } else if (response === '1') {
  //                 Swal.fire({
  //                     title: 'Something Went Wrong',
  //                     text: 'we are unable to save this project',
  //                     icon: 'error',
  //                 })
  //             } else {
  //                 console.log('Hello? Something Went Wrong on Submitting this data');
  //             }
  //         },
  //         error: function(xhr, status, error) {
  //             console.error(xhr.responseText);
  //         }
  //     });
  // });

  function insertTask() {
    $.ajax({
      type: "POST",
      url: "./php/task_save.php",
      data: JSON.stringify(createdTasks),
      contentType: "application/json",
      success: function (response) {
        console.log(response);
        if (response === "0") {
          Swal.fire({
            title: "Project Saved",
            text: "A New Project has been created and can be viewed in Project List",
            icon: "success",
          }).then(function () {
            location.reload();
          });
        } else if (response === "1") {
          Swal.fire({
            title: "Something Went Wrong",
            text: "we are unable to save this project",
            icon: "error",
          });
        } else {
          console.log("Hello? Something Went Wrong on Submitting this data");
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  }

  // $('#projectFormSubmit').on('click', function() {
  //     if(createdTasks.length != 0) {
  //         var form = document.getElementById('projectFormCreate');
  //         if (form.checkValidity()) {
  //             $('#projectFormCreate').submit();
  //         } else {
  //             form.reportValidity();
  //         }
  //     } else {
  //         Swal.fire({
  //             title: 'Oops',
  //             text: 'There are no Tasks for this Project yet.',
  //             icon: 'warning',
  //         })
  //     }
  // });

  $("#saveTaskBtn").click(function (event) {
    event.preventDefault();

    let selectedWorkers = [];
    $('#selected-workers-list input[name="selected_workers[]"]').each(
      function () {
        selectedWorkers.push($(this).val());
      }
    );

    let selectedMaterials = [];
    $('#selected-materials-list input[name="selected_materials[]"]').each(
      function () {
        selectedMaterials.push($(this).val());
      }
    );

    let selectedEquipment = [];
    $('#selected-equipment-list input[name="selected_equipment[]"]').each(
      function () {
        selectedEquipment.push($(this).val());
      }
    );

    var taskFormAddData = {
      task_name: $("#taskNameAdd").val(),
      task_description: $("#taskDescriptionAdd").val(),
      task_start_date: $("#taskStartDateAdd").val(),
      workers: selectedWorkers,
      items: selectedMaterials,
      equipment: selectedEquipment,
      task_due_date: $("#taskDueDateAdd").val(),
      task_status: $("#taskStatusAdd").val(),
      task_priority: $("#taskPriorityAdd").val(),
    };

    createdTasks.push(taskFormAddData);
    num_task = createdTasks.length;

    console.table(taskFormAddData)
    console.log(num_task);

    function createdTasksList() {
        $('#projectCreateTasksList').empty();

        var structure = `
        <table class="table table-bordered table-striped" id="taskTableAdd">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Task Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Manage</th>
                </tr>
            </thead>
            <tbody>
            `;

            createdTasks.forEach(function(data) {
                var formattedStartDate = formatDate(data.task_start_date);
                var formattedDueDate = formatDate(data.task_due_date);
                var priority = data.task_priority;

                if (priority === '0') {
                    formattedPriority = 'Low';
                } else if (priority === '1') {
                    formattedPriority = 'Medium';
                } else if (priority === '2') {
                    formattedPriority = 'High';
                }

                structure +=`
                <tr>
                    <td>${data.task_name}</td>
                    <td>${data.task_description}</td>
                    <td>${formattedStartDate}</td>
                    <td>${formattedDueDate}</td>
                    <td>${formattedPriority}</td>
                    <td>
                        <button class="btn btn-danger btn-remove">Remove</button>
                    </td>
                </tr>
                `;
            })
            structure +=`
            </tbody>
        </table>
        `;

        $('#projectCreateTasksList').append(structure);

        $('#taskNameAdd').val('');
        $('#taskDescriptionAdd').val('');
        $('#taskStartDateAdd').val('');
        $('#taskDueDateAdd').val('');
        $('#taskPriorityAdd').val('');
        $('#selected-materials-list .selected-material').remove();
        $('#selected-workers-list .selected-workers').remove();
        $('#addTaskModal').modal('hide');
        $('#total_task').val(num_task);
    }

    createdTasksList();
  });

  function cleanTaskListDisplay() {
    if (createdTasks.length === 0) {
      $("#projectCreateTasksList").empty();
    }
  }

  $(document).on("click", "#taskTableAdd .btn-remove", function () {
    var rowIndex = $(this).closest("tr").index();

    createdTasks.splice(rowIndex, 1);

    $(this).closest("tr").remove();

    cleanTaskListDisplay();
  });
});
