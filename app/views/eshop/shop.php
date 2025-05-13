<?php $this->view("header", $data); ?>


<section id="advertisement">
	<div class="container">
		<img src="<?= ASSETS . THEME ?>images/shop/advertisement.jpg" alt="" />
	</div>
</section>

<section>
	<div class="container">
		<div class="row">

			<!-- Sidebar -->
			<?php $this->view("sidebar.inc", $data); ?>

			<div class="col-sm-9 padding-right">
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center">Featured Items</h2>

					<?php if (isset($ROWS) && is_array($ROWS)): ?>
						<?php foreach ($ROWS as $row): ?>

							<?php $this->view("product.inc", $row); ?>

						<?php endforeach; ?>
					<?php endif; ?>

					<?php Page::show_links(); ?>


				</div><!--features_items-->
			</div>
		</div>
	</div>
</section>


<div id="smart-button-container">
	<div style="text-align: center;">
		<div id="paypal-button-container"></div>
	</div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AV8oS88hOSLruLO2qT7t0x4bqLyzOALsxuW8Hvnk3Z2iYKb_pSR07RtJcbtsc_3p6w3bMR3qDyV1nS0B"></script>

<script>
	function initPayPalButton() {
		paypal.Buttons({
			style: {
				shape: 'rect',
				color: 'gold',
				layout: 'vertical',
				label: 'paypal',
			},

			createOrder: function(data, actions) {
				return actions.order.create({
					purchase_units: [{
						"description": "My description",
						"amount": {
							currency_code: "USD",
							value: 8, // Changed from 6 to match item_total + shipping
							breakdown: {
								item_total: {
									currency_code: "USD",
									value: 6
								},
								shipping: {
									currency_code: "USD",
									value: 2
								},
								tax_total: {
									currency_code: "USD",
									value: 0
								}
							}
						}
					}],
					// Added return URLs here
					application_context: {
						return_url: "https://e-shop.infy.uk/public/thanks",
						cancel_url: "https://e-shop.infy.uk/public/cancel"
					}
				});
			},

			onApprove: function(data, actions) {
				return actions.order.capture().then(function(details) {
					alert('Transaction completed by ' + details.payer.name.given_name + '!');
				});
			},

			onError: function(err) {
				console.error('An error occurred during the transaction', err);
			}
		}).render('#paypal-button-container');
	}
	initPayPalButton();
</script>

<?php $this->view("footer", $data); ?>