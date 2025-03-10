<?php $this->view("admin/header", $data); ?>
<?php $this->view("admin/sidebar", $data); ?>

<style type="text/css">
    .add_new {
        width: 500px;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 25px;
        border-radius: 8px;
        z-index: 1000;
    }

    .edit_category {
        width: 500px;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 25px;
        border-radius: 8px;
        z-index: 1000;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .show {
        display: block;
    }

    .hide {
        display: none;
    }

    .content-panel {
        background: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 8px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 0 0.5rem;
    }

    .table-title {
        font-size: 1.25rem;
        color: #2d3748;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .add-button {
        background-color: #3b82f6;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .add-button:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
        margin: 1rem 0;
    }

    .table th {
        background-color: #f8fafc;
        padding: 12px;
        font-weight: 600;
    }

    .table td {
        padding: 12px;
        vertical-align: middle;
    }

    .action-buttons button {
        margin: 0 3px;
        transition: transform 0.2s;
    }

    .action-buttons button:hover {
        transform: scale(1.1);
    }

    .form-group {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .form-group label {
        width: 140px;
        margin-bottom: 0;
        text-align: right;
        font-weight: 500;
        color: #4a5568;
    }

    .form-control {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }


    .status-badge {
        display: inline-block;
        padding: 0.25rem 1.40rem;
        border-radius: 990px;
        font-size: 0.975rem;
        font-weight: 500;
    }

    .status-active {
        cursor: pointer;
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-save {
        background-color: #0080FF;
        color: white;
    }

    .btn-cancel {
        background-color: rgb(241, 50, 50);
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>

<!-- Modal Overlay -->
<div class="modal-overlay" id="modalOverlay"></div>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <div class="table-header">
                <h4 class="table-title"><i class="fa fa-folder-open"></i></i> Products Categories</h4>
                <button class="add-button" onclick="show_add_new(event)">
                    <i class="fa fa-plus"></i> Add New Category
                </button>
            </div>

            <!-- Add New Category Modal -->
            <div class="add_new hide">
                <h4 class="mb"><i class="fa fa-plus-square"></i> Add New Category</h4>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label>Category Name:</label>
                        <input id="category" name="category" type="text" class="form-control" autofocus>
                    </div>

                    <div class="form-group">
                        <label>Parent (optional):</label>
                        <select id="parent" name="parent" class="form-control" required>
                            <?php if (is_array($categories)): ?>
                                <option></option>
                                <?php foreach ($categories as $categ): ?>

                                    <option value="<?= $categ->id ?>"><?= $categ->category ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" onclick="show_add_new()">Close</button>
                        <button type="button" class="btn-save" onclick="collect_data(event)">Save</button>
                    </div>
                </form>
            </div>

            <!-- Edit Category Modal -->
            <div class="edit_category hide">
                <h4 class="mb"><i class="fa fa-plus-square"></i>Edit Category</h4>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label>Category Name:</label>
                        <input id="category_edit" name="category" type="text" class="form-control" autofocus>
                    </div>

                    <div class="form-group">
                        <label>Parent (optional):</label>
                        <select id="parent_edit" name="parent" class="form-control" required>
                            <?php if (is_array($categories)): ?>
                                <option></option>
                                <?php foreach ($categories as $categ): ?>

                                    <option value="<?= $categ->id ?>"><?= $categ->category ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" onclick="show_edit_category(0,'')">Cancel</button>
                        <button type="button" class="btn-save" onclick="collect_edit_data(event)">Save</button>
                    </div>
                </form>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fa fa-tags"></i> Category</th>
                        <th><i class="fa fa-table"></i> Parent</th>
                        <th><i class="fa fa-power-off"></i> Status</th>
                        <th><i class="fa fa-gear"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="table_body">

                    <?= $tbl_rows ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    var EDIT_ID = 0;

    // Show add new
    function show_add_new() {
        var show_edit_box = document.querySelector(".add_new");
        var category_input = document.querySelector("#category");

        if (show_edit_box.classList.contains("hide")) {

            show_edit_box.classList.remove("hide");
            category_input.focus();
        } else {
            show_edit_box.classList.add("hide");
            category_input.value = "";
        }
    }

    // Show edit category
    function show_edit_category(id, category, parent) {

        EDIT_ID = id;
        var show_add_box = document.querySelector(".edit_category");
        var category_input = document.querySelector("#category_edit");
        category_input.value = category;

        var parent_input = document.querySelector("#parent_edit");
        parent_input.value = parent;

        if (show_add_box.classList.contains("hide")) {
            show_add_box.classList.remove("hide");
            category_input.focus();
        } else {
            show_add_box.classList.add("hide");
            category_input.value = "";
        }
    }


    // Collect data
    function collect_data(e) {

        var category_input = document.querySelector("#category");
        if (category_input.value.trim() == "" || !isNaN(category_input.value.trim())) {
            alert("Please enter valid category name");
        }

        var parent_input = document.querySelector("#parent");
        if (isNaN(parent_input.value.trim())) {
            alert("Please enter valid category name");
        }

        var category = category_input.value.trim();
        var parent = parent_input.value.trim();
        send_data({
            category: category,
            parent: parent,
            data_type: 'add_category'
        });
    }

    // collect edit data
    function collect_edit_data(e) {

        var category_input = document.querySelector("#category_edit");
        if (category_input.value.trim() == "" || !isNaN(category_input.value.trim())) {
            alert("Please enter valid category name");
        }

        var parent_input = document.querySelector("#parent_edit");
        if (isNaN(parent_input.value.trim())) {
            alert("Please enter valid category name");
        }

        var category = category_input.value.trim();
        var parent = parent_input.value.trim();
        send_data({
            id: EDIT_ID,
            category: category,
            parent: parent,
            data_type: 'edit_category'
        });
    }

    // Send data
    function send_data(data = {}) {
        var ajax = new XMLHttpRequest();
        ajax.open("POST", "<?= ROOT ?>ajax_category", true);
        ajax.setRequestHeader("Content-Type", "application/json");

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });

        ajax.send(JSON.stringify(data));
    }

    // handle result
    function handle_result(result) {

        if (result != "") {
            var obj = JSON.parse(result);

            if (typeof obj.data_type != 'undefined') {
                if (obj.data_type == "add_new") {
                    if (obj.message_type == "info") {
                        alert(obj.message);
                        show_add_new();

                        var table_body = document.querySelector("#table_body");
                        table_body.innerHTML = obj.data;
                    } else {
                        alert(obj.message);
                    }
                } else
                if (obj.data_type == "edit_category") {

                    show_edit_category(0, '');
                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;
                    alert(obj.message);

                } else
                if (obj.data_type == "disable_row") {
                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;

                } else
                if (obj.data_type == "delete_row") {

                    var table_body = document.querySelector("#table_body");
                    table_body.innerHTML = obj.data;

                    alert(obj.message);
                }
            }
        }
    }

    // Edit row
    function edit_row(id) {
        send_data({
            data
        });
    }

    // Delete row
    function delete_row(id) {
        if (!confirm("Are you sure you want to delete this row?")) {
            return;
        }

        send_data({
            data_type: 'delete_row',
            id: id
        });
    }

    // Disable row
    function disable_row(id, state) {
        send_data({
            data_type: 'disable_row',
            id: id,
            current_state: state
        });
    }
</script>

<?php $this->view("admin/footer", $data); ?>