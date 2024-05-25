<script src="../js/createProject.js"></script>

<!-- Task Modal Add -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel"> <i class="fas fa-plus-circle"></i> Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="projectTaskForm">
                    <input type="text" name="project_name" id="project_name" hidden>
                    <input type="number" name="category_id" id="category_id" hidden>
                    <input type="number" name="pcustomer_id" id="pcustomer_id" hidden>
                    <input type="text" name="description" id="description" hidden>
                    <input type="text" name="address" id="address" hidden>
                    <input type="text" name="position" id="position" hidden>
                    <input type="text" name="date_start" id="date_start" hidden>
                    <input type="text" name="due_date" id="due_date" hidden>
                    <input type="text" name="status" id="status" hidden>

                    <div class="form-group">
                        <label for="taskName">Task Name</label>
                        <input type="text" class="form-control" id="taskNameAdd" name="task_name" placeholder="Enter task name" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Description</label>
                        <textarea class="form-control" id="taskDescriptionAdd" name="task_description" rows="3" placeholder="Enter task description" required></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Worker</label>
                        <div class="worker-con">
                        </div>
                        <?php
                        $workers_query = "SELECT * FROM employee WHERE position = 'Worker'";
                        $available_workers = mysqli_query($con, $workers_query);
                        $workers_count = mysqli_num_rows($available_workers);

                        if ($workers_count > 0) {
                        ?>
                            <select id="workers" name="workers" class="form-control">
                                <option value="" selected disabled>--Select Workers--</option>
                                <?php
                                foreach ($available_workers as $workers) {
                                ?>
                                    <option value="<?= $workers['name'] ?>"><?= $workers['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <?php
                        } else {
                        ?>
                            <option value="" disabled>No Available Project Manager</option>
                        <?php
                        }
                        ?>
                        <div class="selected-workers">
                            <h4>Selected Workers:</h4>
                            <div id="selected-workers-list"></div>
                        </div>

                        <label>Materials</label>
                        <?php
                        $products_query = "SELECT * FROM products";
                        $available_products = mysqli_query($con, $products_query);
                        $product_count = mysqli_num_rows($available_products);

                        if ($product_count > 0) {
                            foreach ($available_products as $product) {
                        ?>
                                <div class="form-group">
                                    <label for="<?= $product['name'] ?>"><?= $product['name'] ?> (Price: <?= $product['price'] ?>)</label>
                                    <input type="number" id="<?= $product['name'] ?>" name="<?= $product['name'] ?>" class="form-control product-quantity" min="0" data-price="<?= $product['price'] ?>">
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <p>No Available Products</p>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <label>Total Price: </label>
                            <input type="text" id="totalPrice" name="totalPrice" class="form-control" readonly>
                        </div>

                        <label>Equipment</label>
                        <?php
                        $equipment_query = "SELECT * FROM equipment";
                        $available_equipment = mysqli_query($con, $equipment_query);
                        $equipment_count = mysqli_num_rows($available_equipment);

                        if ($equipment_count > 0) {
                        ?>
                            <select id="equipment" name="equipment" class="form-control">
                                <option value="" selected disabled>--Select Equipment--</option>
                                <?php
                                foreach ($available_equipment as $equipment) {
                                ?>
                                    <option value="<?= $equipment['name'] ?>"><?= $equipment['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <?php
                        } else {
                        ?>
                            <option value="" disabled>No Available Equipment</option>
                        <?php
                        }
                        ?>
                        <div class="selected-equipment">
                            <h4>Selected Equipment:</h4>
                            <div id="selected-equipment-list"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="taskName">Start Date</label>
                        <input type="datetime-local" class="form-control" id="taskStartDateAdd" name="task_start_date" required>

                        <label for="taskName">Due Date</label>
                        <input type="datetime-local" class="form-control" id="taskDueDateAdd" name="task_due_date" required>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority:</label>
                        <select id="taskPriorityAdd" name="task_priority" class="form-control" required>
                            <option value="" hidden>Select Priority Level</option>
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                        </select>
                    </div>

                    <!-- Removed Status Selection fixed to 0 => Pending -->

                    <input type="text" id="taskStatusAdd" name="task_status" class="form-control" value="0" required readonly hidden>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="saveTaskBtn" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- // Task List Card -->
</div>

<script>
    $(document).ready(function() {
        const productInputs = document.querySelectorAll('.product-quantity');
        const totalPriceField = document.getElementById('totalPrice');

        productInputs.forEach(input => {
            input.addEventListener('input', calculateTotalPrice);
        });

        function calculateTotalPrice() {
            let total = 0;
            productInputs.forEach(input => {
                const price = parseFloat(input.getAttribute('data-price'));
                const quantity = parseInt(input.value) || 0;
                total += price * quantity;
            });
            totalPriceField.value = total.toFixed(2);
        }

        $('#saveTaskBtn').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: './modal/addTask.php',
                type: "POST",
                data: $('#projectTaskForm').serialize(),
                success(response) {
                    console.log(response)
                    $('#addTaskModal').modal('hide');
                    $('#selected-workers-list').empty();
                    $('#selected-equipment-list').empty();
                    $('#projectTaskForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('#equipment').change(function() {
            let selectedValue = $(this).val();
            let selectedText = $("#equipment option:selected").text();

            if (selectedValue) {
                $('#selected-equipment-list').append(`
                    <div class="selected-equipment">
                        <input type="hidden" name="selected_equipment[]" value="${selectedValue}">
                        <span>${selectedText}</span>
                        <button type="button" class="btn btn-danger remove-equipment">Remove</button>
                    </div>
                `);

                $('#equipment').prop('selectedIndex', 0);
            }
        });

        $(document).on('click', '.remove-equipment', function() {
            $(this).closest('.selected-equipment').remove();
        });

        $('#workers').change(function() {
            let selectedValue = $(this).val();
            let selectedText = $("#workers option:selected").text();

            if ($('#selected-workers-list input[value="' + selectedValue + '"]').length == 0) {
                if (selectedValue) {
                    $('#selected-workers-list').append(`
                        <div class="selected-workers">
                            <input type="hidden" name="selected_workers[]" value="${selectedValue}">
                            <span>${selectedText}</span>
                            <button type="button" class="btn btn-danger remove-workers">Remove</button>
                        </div>
                    `);

                    $('#workers').prop('selectedIndex', 0);
                }
            } else {
                alert("Worker already selected.");
            }
        });

        $(document).on('click', '.remove-workers', function() {
            $(this).closest('.selected-workers').remove();
        });
    });
</script>