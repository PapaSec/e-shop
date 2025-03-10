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

		<?php if (is_array($ROWS)): ?>
			<div class="alert alert-info mb-4">
				<p class="mb-0" style="text-align: center;">Fields are required * Fill the form below to continue.</p>
			</div><!--/register-req-->

			<?php 
				
				$address1 		= "";
				$address2 		= "";
				$country		= "";
				$postal_code 	= "";
				$phone_number 	= "";
				$state 			= "";
				$message 		= "";

				if (isset($POST_DATA)){
					extract ($POST_DATA);
				}
			
			?>
			<!--Form Start-->
			<form method="post">
				<div class="shopper-informations">
					<div class="row">

						<div class="col-sm-8 clearfix">
							<div class="bill-to">
								<p>Billing Information</p>
								<div class="form-one">
									<label class="form-label">Address Line 1 *</label>
									<input name="address1" value="<?=$address1?>" class="form-control" type="text" placeholder="Street address" autofocus="autofocus" required><br>

									<label class="form-label">Address Line 2 *</label>
									<input name="address2" value="<?=$address2?>" class="form-control" type="text" placeholder="City or Town" autofocus="autofocus" required><br>

									<label class="form-label">Country *</label>
									<select style="border-radius: 5px;" name="country" class="js-country" oninput="get_states(this.value)" required>
										<?php if($country == ""){
											echo"<option>-- Country --</option>";
										}else{
											echo"<option>$country</option>";
										}?>
										
										<?php if (isset($countries) && $countries): ?>
											<?php foreach ($countries as $row): ?>

												<option value="<?= $row->country ?>"><?= $row->country ?></option>

											<?php endforeach; ?>
										<?php endif; ?>
									</select><br>

								</div>
								<div class="form-two">

									<label class="form-label">Postal Code *</label>
									<input name="postal_code" value="<?=$postal_code?>" class="form-control" type="text" placeholder="Postal Code" required><br>


									<label class="form-label">Phone Number *</label>
									<input name="phone_number" value="<?=$phone_number?>" class="form-control" type="text" placeholder="+27 73 345 6789" required><br>

									<label class="form-label">State/Province *</label>
									<select style="border-radius: 5px;" name="state" value="<?=$state?>" class="js-state" required>
									<?php if($state == ""){
											echo"<option>-- State / Province / Region --</option>";
										}else{
											echo"<option>$state</option>";
										}?>

									</select><br>
								</div>
							</div>
						</div>
						<!-- Shipping Notes -->
						<div class="col-lg-4">
							<div class="card h-100 p-4">
								<p class="mb-4 border-bottom pb-3">Add comments (not required)</p>
								<div class="form-group">
									<textarea class="form-control" name="message"
										placeholder="Add Comments About Your Order"
										rows="12"
										style="resize: none;"><?=$message?></textarea>
								</div>
							</div>
						</div>
					</div>

					<a href="<?= ROOT ?>cart"><input type="button" class="btn btn-warning pull-left" value="BACK TO CART" name=""></a>
					<input type="submit" class="btn btn-warning pull-left" value="Continue" name="" style="margin-left: 10px;">

				</div>
			</form>
			<!-- End Form -->

		<?php else: ?>
			<div class="alert alert-danger">
				<h2 style="text-align: center;"><i class="fa fa-shopping-cart"></i> Your cart is empty!</h2>
			</div>
			<a href="<?= ROOT ?>cart"><input type="button" class="btn btn-warning pull-left" value="BACK TO CART" name=""></a>
		<?php endif; ?>

	</div><br>
</section> <!--/#cart_items-->

<script type="text/javascript">
	function get_states(country) {
		send_data({
			id: country.trim()
		}, "get_states/" + JSON.stringify({
			id: country.trim()
		}));
	}

	// Send data
	function send_data(data = {}, data_type) {
		var ajax = new XMLHttpRequest();

		ajax.open("POST", "<?= ROOT ?>ajax_checkout", true);
		ajax.setRequestHeader("Content-Type", "application/json");
		ajax.addEventListener('readystatechange', function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				handle_result(ajax.responseText);
			}
		});

		var info = {};
		info.data_type = data_type;
		info.data = data;

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
						select_input.innerHTML += "<option value='" + obj.data[i].state + "'>" + obj.data[i].state + "</option>";
					}

				}

			}
		}
	}
</script>

<?php $this->view("footer", $data); ?>