<?php $this->view("header", $data); ?>

<section id="form" style="margin-top: 5px;">
    <div class="container">
        <div class="row" style="text-align: center;">
            <div class="col-sm-4 col-sm-offset-1" style="float: none; display: inline-block;">
                <div class="signup-form">
                    <h2>Create New Account!</h2>
                    <form method="post">
                        <input name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>" type="text" placeholder="Name" />
                        <input name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" type="email" placeholder="Email Address" />
                        <input name="password" type="password" placeholder="Password" />
                        <input name="password2" type="password" placeholder="Confirm Password" />
                        <button type="submit" class="btn btn-default">Register</button>
                    </form>
                    <div style="text-align: left; margin-top: 10px;">
                        Already have an Account? <a href="<?= ROOT ?>login">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Error Pop-up -->
<div id="errorModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
    <div style="background-color: #fff; border-radius: 8px; width: 350px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); overflow: hidden;">
        <!-- Modal Header -->
        <div style="background-color: #f44336; color: white; padding: 15px; text-align: center;">
            <span class="close" style="float: right; font-size: 24px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2 style="margin: 0; font-size: 20px;">Error</h2>
        </div>
        <!-- Modal Body -->
        <div style="padding: 20px; text-align: center; font-size: 16px; color: #333;">
            <p id="errorText" style="white-space: pre-line;"></p> <!-- Use pre-line to handle newlines -->
        </div>
        <!-- Modal Footer -->
        <div style="padding: 10px; text-align: center; background-color: #f9f9f9;">
            <button class="btn-close" style="background-color: #f44336; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px;">Close</button>
        </div>
    </div>
</div>

<!-- Script to Handle Modal -->
<script>
    // Get the modal
    var modal = document.getElementById('errorModal');

    // Get the close button
    var closeBtn = document.querySelector('.close');
    var closeFooterBtn = document.querySelector('.btn-close');

    // Function to show the modal
    function showErrorModal(message) {
        // Replace <br> tags with newlines
        var formattedMessage = message.replace(/<br\s*\/?>/gi, '\n');
        document.getElementById('errorText').innerText = formattedMessage;
        modal.style.display = 'flex';
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
    }

    // Close modal when clicking on close button
    closeBtn.onclick = closeModal;
    closeFooterBtn.onclick = closeModal;

    // Close modal when clicking outside the modal
    window.onclick = function (event) {
        if (event.target === modal) {
            closeModal();
        }
    };

    <?php
    // Check if there's an error and trigger modal if exists
    if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
        echo "showErrorModal('" . addslashes($_SESSION['error']) . "');";
        unset($_SESSION['error']); // Clear the error after displaying
    }
    ?>
</script>

<?php $this->view("footer"); ?>