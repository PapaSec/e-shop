<?php $this->view("header", $data); ?>

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Shopping Cart</li>
			</ol>
		</div>
		<div class="table-responsive cart_info">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Item</td>
						<td class="description"></td>
						<td class="price">Price</td>
						<td class="quantity">Quantity</td>
						<td class="total">Total</td>
						<td></td>
					</tr>
				</thead>
				<tbody>

					<?php if ($ROWS): ?>
						<?php foreach ($ROWS as $row): ?>
							<tr>
								<td class="cart_product">
									<a href=""><img src="<?= $row->image ?>" style="width: 80px;" alt=""></a>
								</td>
								<td class="cart_description">
									<h4><a href=""><?= $row->description ?></a></h4>
									<p>prod ID: <?= $row->id ?></p>
								</td>
								<td class="cart_price">
									<p>R<?= $row->price ?></p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
										<a class="cart_quantity_down" href="<?= ROOT ?>add_to_cart/subtract_quantity/<?= $row->id ?>"> - </a>
										<input oninput="edit_quantity(this.value,'<?= $row->id ?>')" class="cart_quantity_input" type="text" name="quantity" value="<?= $row->cart_qty ?>" autocomplete="off" size="2">
										<a class="cart_quantity_up" href="<?= ROOT ?>add_to_cart/add_quantity/<?= $row->id ?>"> + </a>
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">R<?= $row->price * $row->cart_qty ?></p>
								</td>
								<td class="cart_delete">
									<a class="cart_quantity_delete" delete_id="<?= $row->id ?>" onclick="delete_item(this.getAttribute('delete_id'))" href="<?= ROOT ?>add_to_cart/remove/<?= $row->id ?>"><i class="fa fa-times"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="alert alert-danger" >
							<h2 style="text-align: center; padding: 6px;">No items found in the cart</h2>
						</div>
					<?php endif; ?>
				</tbody>
			</table>
			<div class="pull-right" style="font-size: 20px;">Sub Total: R<?= number_format($sub_total, 2) ?>
			</div>
		</div>
		<a href="<?=ROOT?>checkout"><input type="button" class="btn btn-warning pull-right" value="CHECKOUT" name="" style="margin-left: 10px;"></a>	
		<a href="<?=ROOT?>shop"><input type="button" class="btn btn-warning pull-right" value="CONTINUE SHOPPING" name=""></a>
	</div>
</section> <!--/#cart_items-->
<br>

<script type="text/javascript">
	function edit_quantity(quantity, id) {

		if (isNaN(quantity.trim()))
			return;
		send_data({
			quantity: quantity.trim(),
			id: id.trim()
		}, "edit_quantity");
	}

	function delete_item(id) {
		send_data({
			id: id.trim()
		}, "delete_item");
	}

	// Send data
	function send_data(data = {}, data_type) {
		var ajax = new XMLHttpRequest();

		ajax.open("POST", "<?= ROOT ?>ajax_cart/" + data_type, true);
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

		console.log(result);
		if (result != "") {
			var obj = JSON.parse(result);

			if (typeof obj.data_type != 'undefined') {
				// Add Item
				if (obj.data_type == "edit_quantity") {
					// Update cart total price for this item
					const totalElement = document.querySelector(`tr:has(input[value="${obj.id}"]) .cart_total_price`);
					if (totalElement) {
						totalElement.textContent = "R" + (obj.new_total); // Server must return new_total
					}
				}

				// Delete Item
				if (obj.data_type == "delete_item") {
					// Update cart total price for this item
					const totalElement = document.querySelector(`tr:has(input[value="${obj.id}"]) .cart_total_price`);
					if (totalElement) {
						totalElement.textContent = "R" + (obj.new_total); // Server must return new_total
					}
				}

			}
		}
	}
</script>
<?php $this->view("footer", $data); ?>