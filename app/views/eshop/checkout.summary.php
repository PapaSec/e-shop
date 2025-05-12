<?php $this->view("header", $data); ?>

<?php
if (isset($errors) && count($errors) > 0):
?>
	<div style="padding: 10px;">
		<?php foreach ($errors as $error): ?>
			<div class="alert-danger" style="max-width: 500px; margin: 5px auto; text-align: center; padding: 10px; border-radius: 4px;">
				<?= $error ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Check out</li>
			</ol>
		</div><!--/breadcrums-->

		<?php if (is_array($orders)): ?>

			<div class="alert alert-info mb-4">
				<p class="mb-0" style="text-align: center;">Please confirm the information is correct.</p>
			</div><!--/register-req-->



			<?php foreach ($orders as $order): ?>
				<?php
				$order = (object) $order;

				$order->id = 0;
				?>

				<div class="js-order-details details">

					<!-- Order Details -->
					<div style="display: flex; ">
						<table class="table" style="flex: 1; margin: 4px;">
							<tr>
								<th>Delivery Address 1</th>
								<td>: <?= $order->address1 ?></td>
							</tr>
							<tr>
								<th>Delivery Address 2</th>
								<td>: <?= $order->address2 ?></td>
							</tr>
							<tr>
								<th>State</th>
								<td>: <?= $order->state ?></td>
							</tr>
							<tr>
								<th>Country</th>
								<td>: <?= $order->country ?></td>
							</tr>
						</table>

						<table class="table" style="flex: 1; margin: 4px;">
							<tr>
								<th>Postal Code</th>
								<td>: <?= $order->postal_code ?></td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<td>: <?= $order->phone_number ?></td>
							</tr>
							<tr>
								<th>Message</th>
								<td>: <?= $order->message ?></td>
							</tr>
							<tr>
								<th>Date</th>
								<td>: <?= date("Y-m-d") ?></td>
							</tr>
						</table>
					</div>
					<hr>
					<h4>Order Summary</h4>
					<table class="table">
						<thead>
							<tr>
								<th>Qty</th>
								<th>Description</th>
								<th>Amount</th>
								<th>Total</th>
							</tr>
						</thead>

						<?php if (isset($order_details) && is_array($order_details)): ?>
							<?php foreach ($order_details as $detail): ?>
								<tbody>
									<tr>
										<td><?= $detail->cart_qty ?></td>
										<td><?= $detail->description ?></td>
										<td>R <?= $detail->price ?></td>
										<td>R <?= ($detail->cart_qty * $detail->price) ?></td>
									</tr>
								</tbody>

							<?php endforeach; ?>

						<?php else: ?>
							<div style="text-align: center;">No Order Details Found For This Order!</div>
						<?php endif; ?>

					</table>
					<div class="pull-right">
						<h4>Grand Total: R<?= $sub_total ?></h4>
					</div>
				</div>

			<?php endforeach; ?>

		<?php else: ?>
			<h2 style="text-align: center;"><i class="fa fa-shopping-cart">
				</i> Your cart is empty!
			</h2>
		<?php endif; ?>
		<hr style="clear: both;">

		<form method="post">
			<input type="hidden" name="POST_DATA" value="1">
			<input type="submit" class="btn btn-warning pull-right" value="PAY" style="margin-left: 10px;">
		</form>
		<input type="button" class="btn btn-warning pull-right" value="BACK TO CHECKOUT" onclick="window.location.href='<?= ROOT ?>checkout'">
	</div>


	</div><br>
</section> <!--/#cart_items-->

<script type="text/javascript">
	function get_states(id) {
		send_data({
			id: id.trim()
		}, "get_states/" + JSON.stringify({
			id: id.trim()
		}));
	}

	// Send data
	function send_data(data = {}, data_type) {
		var ajax = new XMLHttpRequest();

		ajax.open("POST", "<?= ROOT ?>ajax_checkout/" + data_type, true);
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

				if (obj.data_type == "get_states") {

					var select_input = document.querySelector(".js-state");
					select_input.innerHTML = "<option>-- State / Province / Region --</option>";

					for (var i = 0; i < obj.data.length; i++) {
						select_input.innerHTML += "<option value='" + obj.data[i].id + "'>" + obj.data[i].state + "</option>";
					}

				}

			}
		}
	}
</script>

<?php $this->view("footer", $data); ?>