<section id="slider">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    
                    <?php if (isset($slider) && is_array($slider)): ?>
                    
                        <ol class="carousel-indicators">
                            <?php foreach ($slider as $index => $row): ?>
                                <li data-target="#slider-carousel" 
                                    data-slide-to="<?= $index ?>" 
                                    class="<?= ($index == 0) ? 'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php foreach ($slider as $index => $row): ?>
                                <div class="item <?= ($index == 0) ? 'active' : '' ?>">
                                    <div class="col-sm-6">
                                        <h1><span><?=substr($row->header1_text,0,1)?></span><?=substr($row->header1_text,1)?></h1>
                                        <h2><?= htmlspecialchars( $row->header2_text) ?></h2>
                                        <p><?= htmlspecialchars($row->text) ?></p>
                                        <a href="<?= $row->link ?>" class="btn btn-default get">
                                            Get it now
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <img src="<?=$row->image ?>" class="girl img-responsive" alt="">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <a class="left control-carousel" href="#slider-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right control-carousel" href="#slider-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                        
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>