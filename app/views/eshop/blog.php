<?php $this->view("header", $data); ?>

<section>
	<div class="container">
		<div class="row">
			<?php $this->view("sidebar.inc", $data); ?>

			<div class="col-sm-9">
				<div class="blog-post-area">
					<h2 class="title text-center">Latest From our Blog</h2>

					<?php if (isset($ROWS) && is_array($ROWS)): ?>
						<?php foreach ($ROWS as $row): ?>
							<!--single-blog-post-->
							<div class="single-blog-post">
								<h3><?= $row->title ?></h3>
								<div class="post-meta">
									<ul>
										<li><i class="fa fa-user"></i> Mac Doe</li>
										<li><i class="fa fa-clock-o"></i><?= date("H:i a", strtotime($row->date)) ?></li>
										<li><i class="fa fa-calendar"></i><?= date("M jS, Y", strtotime($row->date)) ?></li>
									</ul>
									<span>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half-o"></i>
									</span>
								</div>
								<a href="">
									<img src="<?= ROOT . $row->image ?>" alt="">
								</a>
								<p><?= $row->post ?></p>
								<a class="btn btn-primary" href="">Read More</a>
							</div>
							<!--End single-blog-post-->
						<?php endforeach; ?>
					<?php endif; ?>

					<div class="pagination-area">
						<ul class="pagination">
							<li><a href="" class="active">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->view("footer", $data); ?>