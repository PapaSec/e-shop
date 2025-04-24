<?php $this->view("admin/header", $data); ?>

<?php $this->view("admin/sidebar", $data); ?>

<style type="text/css">
    .add_new,
    .edit_product {
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

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 1.40rem;
        border-radius: 990px;
        font-size: 0.975rem;
        font-weight: 500;
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
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

    .edit_product_images {
        display: flex;
        width: 100%;
        margin-left: 155px;
    }

    .edit_product_images img {
        display: 1;
        width: 60px;
        height: 60px;
        margin: 2px;
        border-radius: 8px;
    }
</style>

<!-- Modal Overlay -->
<div class="modal-overlay" id="modalOverlay"></div>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">

            <!-- Search-Box -->
            <form method="get">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Description</th>
                        <td>
                            <input type="text" class="form-control" name="description" placeholder="Search here..." autofocus="true">
                        </td>
                        <th>Category</th>
                        <td>
                            <select class="form-control" name="category">
                                <option>--Any Category--</option>
                                <?php Search::get_categories(); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>
                            <div class="form-inline">
                                <label for="">Min :</label>
                                <input type="number" class="form-control" value="0" step="0.01" name="min-price">
                                <label for="">Max :</label>
                                <input type="number" class="form-control" value="0" step="0.01" name="max-price">
                            </div>
                        </td>
                        <th>Quantity</th>
                        <td>
                            <div class="form-inline">
                                <label for="">Min :</label>
                                <input type="number" class="form-control" value="0" step="0.01" name="min-qty">
                                <label for="">Max :</label>
                                <input type="number" class="form-control" value="0" step="0.01" name="max-qty">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Brands</th>
                        <td colspan="3">
                            <?php Search::get_brands(); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Year</th>
                        <td colspan="2">
                            <select class="form-control" name="year">
                                <option>--Any Year--</option>
                                <?php Search::get_years(); ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" class="btn btn-success" name="search" value="Search">
                        </td>
                    </tr>
                    <tr>

                    </tr>
                </table>
            </form>
            <!-- End-Search-Box -->


            <div class="table-header">
                <h4 class="table-title"><i class="fa fa-folder-open"></i> Products</h4>
                <button class="add-button" onclick="show_add_new(event)">
                    <i class="fa fa-plus"></i> Add New Product
                </button>
            </div>

            <!-- Add New Product Modal -->
            <div class="add_new hide">
                <h4 class="mb"><i class="fa fa-plus-square"></i> Add New Product</h4>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Name:</label>
                        <input id="description" name="description" type="text" class="form-control" required autofocus>
                    </div>

                    <div class="form-group">
                        <label>Quantity:</label>
                        <input id="quantity" name="quantity" type="number" value="1" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category:</label>
                        <select id="category" name="category" class="form-control" required>
                            <?php if (is_array($categories)): ?>
                                <option></option>
                                <?php foreach ($categories as $categ): ?>

                                    <option value="<?= $categ->id ?>"><?= $categ->category ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand:</label>
                        <select id="brand" name="brand" class="form-control" required>
                            <?php if (is_array($brands)): ?>
                                <option></option>
                                <?php foreach ($brands as $brand): ?>

                                    <option value="<?= $brand->id ?>"><?= $brand->brand ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Price:</label>
                        <input id="price" name="price" type="number" placeholder="0.00" step="0.01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Image:</label>
                        <input id="image" name="image" type="file" onchange="display_image(this.files[0],this.name,'js-product-images-add')" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Image 2 (Optional):</label>
                        <input id="image2" name="image2" type="file" onchange="display_image(this.files[0],this.name,'js-product-images-add')" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Image 3 (Optional):</label>
                        <input id="image3" name="image3" type="file" onchange="display_image(this.files[0],this.name,'js-product-images-add')" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Image 4 (Optional):</label>
                        <input id="image4" name="image4" type="file" onchange="display_image(this.files[0],this.name,'js-product-images-add')" class="form-control">
                    </div>
                    <div class="js-product-images-add edit_product_images">
                        <img src="">
                        <img src="">
                        <img src="">
                        <img src="">
                    </div>

                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" onclick="show_add_new()">Close</button>
                        <button type="button" class="btn-save" onclick="collect_data(event)">Save</button>
                    </div>
                </form>
            </div>

            <!-- Edit Product Modal -->
            <div class="edit_product hide">
                <h4 class="mb"><i class="fa fa-plus-square"></i> Edit Product</h4>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label>Product Name:</label>
                        <input id="edit_description" name="product" type="text" class="form-control" autofocus>
                    </div>

                    <div class="form-group">
                        <label>Quantity:</label>
                        <input id="edit_quantity" name="quantity" type="number" value="1" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category:</label>
                        <select id="edit_category" name="category" class="form-control" required>
                            <option></option>
                            <?php if (is_array($categories)): ?>
                                <?php foreach ($categories as $categ): ?>

                                    <option value="<?= $categ->id ?>"><?= $categ->category ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand:</label>
                        <select id="edit_brand" name="brand" class="form-control" required>
                            <option></option>
                            <?php if (is_array($brands)): ?>
                                <?php foreach ($brands as $brand): ?>

                                    <option value="<?= $brand->id ?>"><?= $brand->brand ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Price:</label>
                        <input id="edit_price" name="price" type="number" placeholder="0.00" step="0.01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Image:</label>
                        <input id="edit_image" name="image" onchange="display_image(this.files[0],this.name,'js-product-images-edit')" type="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Image 2 (Optional):</label>
                        <input id="edit_image2" name="image2" onchange="display_image(this.files[0],this.name,'js-product-images-edit')" type="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Image 3 (Optional):</label>
                        <input id="edit_image3" name="image3" onchange="display_image(this.files[0],this.name,'js-product-images-edit')" type="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Image 4 (Optional):</label>
                        <input id="edit_image4" name="image4" onchange="display_image(this.files[0],this.name,'js-product-images-edit')" type="file" class="form-control">
                    </div>

                    <div class="js-product-images-edit edit_product_images">

                    </div>
                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" onclick="show_edit_product(0,'',false)">Cancel</button>
                        <button type="button" class="btn-save" onclick="collect_edit_data(event)">Save</button>
                    </div>
                </form>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fa fa-bullhorn"></i> Product ID</th>
                        <th> Product Name</th>
                        <th> Quantity</th>
                        <th> Category</th>
                        <th> Brand</th>
                        <th> Price</th>
                        <th> date</th>
                        <th> Images</th>
                        <th><i class="fa fa-gear"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    <?= $tbl_rows ?>
                    <tr>
                        <td colspan="8"><?php Page::show_links(); ?></td>
                    </tr>
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
        var product_input = document.querySelector("#description");

        if (show_edit_box.classList.contains("hide")) {

            show_edit_box.classList.remove("hide");
            product_input.focus();
        } else {
            show_edit_box.classList.add("hide");
            product_input.value = "";
        }
    }

    // Show edit product
    function show_edit_product(id, product, e) {

        var show_add_box = document.querySelector(".edit_product");
        var edit_description_input = document.querySelector("#edit_description");
        if (e) {
            var a = (e.currentTarget.getAttribute("info"));
            var info = JSON.parse(a.replaceAll("'", '"'));

            EDIT_ID = info.id;

            edit_description_input.value = info.description;

            var edit_quantity_input = document.querySelector("#edit_quantity");
            edit_quantity_input.value = info.quantity;

            var edit_category_input = document.querySelector("#edit_category");
            edit_category_input.value = info.category;

            var edit_price_input = document.querySelector("#edit_price");
            edit_price_input.value = info.price;

            var edit_category_input = document.querySelector("#edit_category");
            edit_category_input.value = info.category;

            var product_images_input = document.querySelector(".js-product-images-edit");
            product_images_input.innerHTML = `<img src="<?= ROOT ?>${info.image}" />`;
            product_images_input.innerHTML += `<img src="<?= ROOT ?>${info.image2}" />`;
            product_images_input.innerHTML += `<img src="<?= ROOT ?>${info.image3}" />`;
            product_images_input.innerHTML += `<img src="<?= ROOT ?>${info.image4}" />`;

        }

        if (show_add_box.classList.contains("hide")) {
            show_add_box.classList.remove("hide");
            edit_description_input.focus();
        } else {
            show_add_box.classList.add("hide");
            edit_description_input.value = "";
        }
    }


    // Collect data
    function collect_data(e) {

        var product_input = document.querySelector("#description");
        if (product_input.value.trim() == "" || !isNaN(product_input.value.trim())) {

            alert("Please enter a valid product name");
            return;
        }

        var quantity_input = document.querySelector("#quantity");
        if (quantity_input.value.trim() == "" || isNaN(quantity_input.value.trim())) {

            alert("Please enter a valid quantity");
            return
        }

        var category_input = document.querySelector("#category");
        if (category_input.value.trim() == "" || isNaN(category_input.value.trim())) {

            alert("Please enter a valid category");
            return
        }

        var brand_input = document.querySelector("#brand");
        if (brand_input.value.trim() == "" || isNaN(brand_input.value.trim())) {

            alert("Please enter a valid brand");
            return
        }


        var price_input = document.querySelector("#price");
        if (price_input.value.trim() == "" || isNaN(price_input.value.trim())) {

            alert("Please enter a valid price");
            return
        }

        var image_input = document.querySelector("#image");

        if (image_input.files.length == 0) {
            alert("Please enter a valid main image");
            return;
        }

        // create form
        const data = new FormData();

        var image2_input = document.querySelector("#image2");
        if (image2_input.files.length > 0) {

            data.append('image2', image2_input.files[0]);
        }

        var image3_input = document.querySelector("#image3");
        if (image3_input.files.length > 0) {

            data.append('image3', image3_input.files[0]);
        }

        var image4_input = document.querySelector("#image4");
        if (image4_input.files.length > 0) {

            data.append('image4', image4_input.files[0]);
        }

        data.append('description', product_input.value.trim());
        data.append('quantity', quantity_input.value.trim());
        data.append('category', category_input.value.trim());
        data.append('brand', brand_input.value.trim());
        data.append('price', price_input.value.trim());
        data.append('data_type', 'add_product');
        data.append('image', image_input.files[0]);

        send_data_files(data);
    }


    // collect edit data
    function collect_edit_data(e) {

        var product_input = document.querySelector("#edit_description");
        if (product_input.value.trim() == "" || !isNaN(product_input.value.trim())) {
            alert("Please enter a valid product name");
            return;
        }

        var quantity_input = document.querySelector("#edit_quantity");
        if (quantity_input.value.trim() == "" || isNaN(quantity_input.value.trim())) {
            alert("Please enter a valid quantity");
            return
        }

        var category_input = document.querySelector("#edit_category");
        if (category_input.value.trim() == "" || isNaN(category_input.value.trim())) {
            alert("Please enter a valid category");
            return
        }

        var price_input = document.querySelector("#edit_price");
        if (price_input.value.trim() == "" || isNaN(price_input.value.trim())) {
            alert("Please enter a valid price");
            return
        }

        // create form
        var data = new FormData();

        var image_input = document.querySelector("#edit_image");
        if (image_input.files.length > 0) {
            data.append('image', image_input.files[0]);
        }

        var image2_input = document.querySelector("#edit_image2");
        if (image2_input.files.length > 0) {
            data.append('image2', image2_input.files[0]);
        }

        var image3_input = document.querySelector("#edit_image3");
        if (image3_input.files.length > 0) {
            data.append('image3', image3_input.files[0]);
        }

        var image4_input = document.querySelector("#edit_image4");
        if (image4_input.files.length > 0) {
            data.append('image4', image4_input.files[0]);
        }

        data.append('description', product_input.value.trim());
        data.append('quantity', quantity_input.value.trim());
        data.append('category', category_input.value.trim());
        data.append('price', price_input.value.trim());
        data.append('data_type', 'edit_product');
        data.append('id', EDIT_ID);

        send_data_files(data);
    }

    // Send data
    function send_data(data = {}) {

        var ajax = new XMLHttpRequest();
        ajax.open("POST", "<?= ROOT ?>ajax_product", true);
        ajax.setRequestHeader("Content-Type", "application/json");

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });

        ajax.send(JSON.stringify(data));
    }

    function send_data_files(formdata) {

        var ajax = new XMLHttpRequest();
        ajax.open("POST", "<?= ROOT ?>ajax_product", true);

        // ajax.setRequestHeader("Content-Type", "application/json");

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        });


        ajax.send(formdata);
    }

    // handle result
    function handle_result(result) {
        console.log(result);
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
                if (obj.data_type == "edit_product") {

                    show_edit_product(0, '', false);

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

    function display_image(file, name, element) {
        var index = 0;
        if (name == "image2") {
            index = 1;
        } else
        if (name == "image3") {
            index = 2;
        } else
        if (name == "image4") {
            index = 3;
        }

        var imgage_holder = document.querySelector("." + element);
        var images = imgage_holder.querySelectorAll("IMG");

        images[index].src = URL.createObjectURL(file);
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