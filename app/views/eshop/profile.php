<?php $this->view("header", $data); ?>

<style>
    .details {

        background-color: #eee;
        padding: 10px;
        box-shadow: 0px 0px 10px #aaa;
        width: 100%;
        position: absolute;
        min-height: 100px;
        z-index: 2;
        left: 0px;
    }

    .hide {
        display: none;
    }
</style>

<section id="main-content" style="padding: 20px;">
    <section class="wrapper">
        <div style="min-height: 300px; max-width: 1000px; margin: 0 auto; padding: 20px;">

            <!-- Profile data -->

            <!-- Dashboard Card -->
            <?php if (is_object($profile_data)): ?>

                <div style="background-color: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center; max-width: 400px; margin: 0 auto -20px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <!-- User Profile Section -->
                    <div>
                        <div style="color: #333; font-size: 18px; font-weight: 600; margin-bottom: 10px;">
                            MY ACCOUNT
                        </div>
                        <p>
                            <img src="<?= ASSETS . THEME ?>admin/img/ui-zac.jpg" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); margin-bottom: 15px;">
                        </p>
                        <p style="font-size: 20px; color: #1a73e8; font-weight: 700; margin-bottom: 15px;">
                            <?= $profile_data->name ?>
                        </p>

                        <!-- User Details -->
                        <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                            <div style="flex: 1; padding: 0 10px;">
                                <p style="font-size: 14px; color: #777; margin-bottom: 5px;">MEMBER SINCE</p>
                                <p style="font-size: 18px; color: #333; font-weight: 600;">
                                    <?= date("jS M Y", strtotime($profile_data->date)) ?>
                                </p>
                            </div>
                            <div style="flex: 1; padding: 0 10px;">
                                <p style="font-size: 14px; color: #777; margin-bottom: 5px;">TOTAL SPEND</p>
                                <p style="font-size: 18px; color: #333; font-weight: 600;">R 47.60</p>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr style="border: 0; height: 1px; background: #eee; margin: 20px 0;">

                        <!-- Action Links -->
                        <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                            <div style="flex: 1; padding: 0 10px;">
                                <p style="font-size: 14px; cursor: pointer; color: #34a853; transition: color 0.3s ease;">
                                    <i class="fa fa-edit"></i> EDIT
                                </p>
                            </div>
                            <div style="flex: 1; padding: 0 10px;">
                                <p style="font-size: 14px; cursor: pointer; color: #ea4335; transition: color 0.3s ease;">
                                    <i class="fa fa-minus"></i> DELETE
                                </p>
                            </div>
                        </div>
                    </div>
                </div><!-- /Dashboard Card -->
                <br><br>

                <!-- End Profile data -->
                <?php if (is_array($data['orders'])): ?>
                    <div>
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                    <th>Delivery Address</th>
                                    <th>City/State</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th>Order Total</th>
                                    <th>...</th>
                                </tr>
                            </thead>
                            <tbody onclick="show_details(event)">
                                <?php foreach ($orders as $order): ?>

                                    <?php
                                    $status = is_paid($order);
                                    ?>
                                    <tr style="position: relative;">
                                        <td><?= $order->id ?></td>
                                        <td><?= date("jS M Y H:i a", strtotime($order->date)) ?></td>
                                        <td><?= $order->delivery_address ?></td>
                                        <td><?= $order->state ?></td>
                                        <td><?= $order->phone_number ?></td>
                                        <td><?= $status ?></td>
                                        <td>R <?= $order->total ?></td>
                                        <td>
                                            <i class="fa fa-arrow-down"></i>
                                            <div class="js-order-details details hide">
                                                <a style="float: right; cursor: pointer;">Close</a>
                                                <h4>Order #<?= $order->id ?></h4>
                                                <table class="table">
                                                    <thead>
                                                        <tr>

                                                            <th>Qty</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (isset($order->details) && is_array($order->details)): ?>
                                                            <?php foreach ($order->details as $detail): ?>
                                                                <tr>

                                                                    <td><?= $detail->qty ?></td>
                                                                    <td><?= $detail->description ?></td>
                                                                    <td>R <?= $detail->amount ?></td>
                                                                    <td>R <?= $detail->total ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div>No Order Details Found For This Order!</div>
                                                        <?php endif; ?>
                                                    </tbody>


                                                    <?php if (isset($order->details) && is_array($order->details)): ?>
                                                        <?php foreach ($order->details as $detail): ?>

                                                        <?php endforeach; ?>

                                                    <?php else: ?>
                                                        <div>No Order Details Found For This Order!</div>
                                                    <?php endif; ?>

                                                </table>
                                                <div class="pull-right">
                                                    <h4>Grand Total: R<?= $order->grand_total ?></h4>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <<div class="user-not-found" style="text-align: center; padding: 40px 20px; margin: 20px auto; max-width: 500px; background-color: #f8f9fa; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <h3 style="color: #dc3545; margin-bottom: 15px;">This User Has No Orders Yet</h3>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="user-not-found" style="text-align: center; padding: 40px 20px; margin: 20px auto; max-width: 500px; background-color: #f8f9fa; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h3 style="color: #dc3545; margin-bottom: 15px;">User Not Found</h3>
        <p style="color: #6c757d;">The user profile you're looking for doesn't exist or may have been removed.</p>
    </div>
<?php endif; ?>
</div>
    </section>
</section>

<script type="text/javascript">
    function show_details(e) {

        var row = e.target.parentNode;
        while (row.tagName != "TR")
            row = row.parentNode;

        var details = row.querySelector(".js-order-details");


        // get all rows
        var all = e.currentTarget.querySelectorAll(".js-order-details");
        for (var i = 0; i < all.length; i++) {
            if (all[i] != details) {
                all[i].classList.add("hide");
            }
        }

        if (details.classList.contains("hide")) {
            details.classList.remove("hide");
        } else {
            details.classList.add("hide");
        }
    }
</script>
<?php $this->view("footer", $data); ?>