<footer id="footer"><!--Footer-->
	<div class="footer-top">
		<div class="container">
			<div class="row">



			</div>
		</div>
	</div>

	<div class="footer-widget">
		<div class="container">
			<div class="row">
				<div class="col-sm-2">
					<div class="single-widget">
						<h2>Service</h2>
						<ul class="nav nav-pills nav-stacked">
							<li><a href="#">Online Help</a></li>
							<li><a href="#">Contact Us</a></li>
							<li><a href="#">Order Status</a></li>
							<li><a href="#">Change Location</a></li>
							<li><a href="#">FAQ'S</a></li>

						</ul>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="single-widget">
						<h2>Quock Shop</h2>
						<ul class="nav nav-pills nav-stacked">
							<li><a href="#">T-Shirt</a></li>
							<li><a href="#">Mens</a></li>
							<li><a href="#">Womens</a></li>
							<li><a href="#">Gift Cards</a></li>
							<li><a href="#">Shoes</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="single-widget">
						<h2>Policies</h2>
						<ul class="nav nav-pills nav-stacked">
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Privecy Policy</a></li>
							<li><a href="#">Refund Policy</a></li>
							<li><a href="#">Billing System</a></li>
							<li><a href="#">Ticket System</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="single-widget">
						<h2>About Shopper</h2>
						<ul class="nav nav-pills nav-stacked">
							<li><a href="#">Careers</a></li>
							<li><a href="#">Store Location</a></li>
							<li><a href="#">Affillate Program</a></li>
							<li><a href="#">Copyright</a></li>
							<?php if (isset($data['user_data']) && $data['user_data']->rank == 'admin'): ?>
								<li><a href="<?= ROOT ?>admin" style="display: inline-block; background-color: #e74c3c; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold; text-decoration: none; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; transition: background-color 0.3s;">Admin</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<div class="col-sm-3 col-sm-offset-1">
					<div class="single-widget">
						<h2>About Shopper</h2>
						<form action="#" class="searchform">
							<input type="text" placeholder="Your email address" />
							<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
							<p>Get the most recent updates from <br />our site and be updated your self...</p>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<p class="pull-left">Copyright © <?php echo date('Y'); ?> E-SHOPPER Inc. All rights reserved.</p>
				<p class="pull-right">Developed By <span><a target="_blank" href="#">Ron.Dev</a></span></p>
			</div>
		</div>
	</div>

</footer><!--/Footer-->


<script src="<?= ASSETS . THEME ?>/js/jquery.js"></script>
<script src="<?= ASSETS . THEME ?>/js/bootstrap.min.js"></script>
<script src="<?= ASSETS . THEME ?>/js/jquery.scrollUp.min.js"></script>
<script src="<?= ASSETS . THEME ?>/js/price-range.js"></script>
<script src="<?= ASSETS . THEME ?>/js/jquery.prettyPhoto.js"></script>
<script src="<?= ASSETS . THEME ?>/js/main.js"></script>
</body>

</html>