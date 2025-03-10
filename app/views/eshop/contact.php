<?php $this->view("header", $data); ?>

<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form">

                    <h2 class="title text-center">Get In Touch</h2>

                    <?php if (is_array($errors) && count($errors) > 0) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <div><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success'])) : ?>        
                        <div class="alert alert-success">Message sent successfully</div>
                    <?php endif; ?>

                    <form id="main-contact-form" method="post" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" required 
                                       placeholder="Name" value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES) ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" required 
                                       placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" name="subject" class="form-control" required 
                                       placeholder="Subject" value="<?= htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES) ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea name="message" class="form-control" rows="8" required
                                          style="min-height: 150px;" 
                                          placeholder="Your Message Here"><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES) ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right" name="submit">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div class="contact-info">
                    <h2 class="title text-center">Contact Info</h2>
                    <address class="text-muted">
                        <?= nl2br(htmlspecialchars(Settings::contact_info(), ENT_QUOTES)) ?>
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">Social Links</h2>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="<?= htmlspecialchars(Settings::facebook_link(), ENT_QUOTES) ?>" 
                                   class="text-primary" target="_blank" rel="noopener">
                                    <i class="fa fa-facebook"></i> Facebook
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?= htmlspecialchars(Settings::x_link(), ENT_QUOTES) ?>" 
                                   class="text-info" target="_blank" rel="noopener">
                                    <i class="fa fa-twitter"></i> Twitter
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?= htmlspecialchars(Settings::google_plus_link(), ENT_QUOTES) ?>" 
                                   class="text-danger" target="_blank" rel="noopener">
                                    <i class="fa fa-google-plus"></i> Google+
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view("footer", $data); ?>