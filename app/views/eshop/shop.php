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

					<br style="clear: both;">
					<ul class="pagination">
						<li><a href="<?= Page::links()->prev ?>">Prev</a></li>

						<?php
						$max = Page::links()->current + 5;
						$cur = (Page::links()->current > 5) ? Page::links()->current - 5 : 1;
						?>
						<?php for ($i = $cur; $i < $max; $i++): ?>
							<li <?= (Page::links()->current == $i) ? 'class="active"' : ''; ?>><a href="<?= Page::generate($i) ?>"><?= $i ?></a></li>
							<!--<li><a href="">&raquo;</a></li>-->
						<?php endfor; ?>

						<li><a href="<?= Page::links()->next ?>">Next</a></li>
					</ul>
				</div><!--features_items-->
			</div>
		</div>
	</div>
</section>

<?php $this->view("footer", $data); ?>