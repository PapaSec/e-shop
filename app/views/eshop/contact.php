<?php $this->view("header", $data); ?>

<style>
    /* Map Styling */
    #contact-page iframe {
        width: 100%;
        height: 300px;
        /* Adjust height as needed */
        border: 0;
        border-radius: 10px;
        /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }

    /* Contact Page Layout */
    #contact-page .bg {
        padding: 20px;
        background-color: #f9f9f9;
        /* Light background */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }

    #contact-page .contact-form,
    #contact-page .contact-info {
        background-color: #fff;
        /* White background for forms */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }

    #contact-page .title {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
        /* Darker text for headings */
    }

    #contact-page .form-group {
        margin-bottom: 15px;
    }

    #contact-page .btn-primary {
        background-color: #007bff;
        /* Primary button color */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
    }

    #contact-page .btn-primary:hover {
        background-color: #0056b3;
        /* Darker shade on hover */
    }

    #contact-page .social-networks ul {
        padding-left: 0;
    }

    #contact-page .social-networks li {
        list-style: none;
    }

    #contact-page .social-networks a {
        text-decoration: none;
        color: #333;
    }

    #contact-page .social-networks a:hover {
        color: #007bff;
        /* Highlight on hover */
    }
</style>

<div id="contact-page" class="container">
    <div class="bg">
        <div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3578.940443581909!2d27.808083925405978!3d-26.231124615070843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e95a394d27d840b%3A0x20bb48fe488b7a4d!2sSasol%20Azalia!5e0!3m2!1sen!2sza!4v1741789424431!5m2!1sen!2sza" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center">Get In Touch</h2>

                    <?php if (is_array($errors) && count($errors) > 0) : ?>
                        <div class="status alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <div><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success'])) : ?>
                        <div class="status alert alert-success">Message sent successfully</div>
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