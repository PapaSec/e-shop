<?php $this->view("admin/header", $data); ?>
<?php $this->view("admin/sidebar", $data); ?>

<style>
    .js-order-details {
        background-color: #f8f9fa;
        padding: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        display: none;
    }

    .table-details {
        background-color: white;
        border-radius: 0.25rem;
    }

    [aria-expanded="true"] .fa-arrow-down {
        transform: rotate(180deg);
    }
</style>

<div class="container-fluid">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Order No</th>
                <th>Customer</th>
                <th>Order Date</th>
                <th>Delivery Address</th>
                <th>City/State</th>
                <th>Phone</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr data-order-id="<?= htmlspecialchars($order->id ?? '', ENT_QUOTES) ?>">
                    <td><?= htmlspecialchars($order->id ?? '', ENT_QUOTES) ?></td>
                    <td>
                        <a href="<?= ROOT ?>profile/<?= htmlspecialchars($order->user->url_address ?? '', ENT_QUOTES) ?>">
                            <?= htmlspecialchars($order->user->name ?? 'Unknown', ENT_QUOTES) ?>
                        </a>
                    </td>
                    <td><?= date("jS M Y H:i a", strtotime($order->date)) ?></td>
                    <td><?= htmlspecialchars($order->delivery_address ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($order->state ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($order->phone_number ?? '', ENT_QUOTES) ?></td>
                    <td>R <?= number_format($order->total ?? 0, 2) ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary"
                            aria-expanded="false"
                            onclick="toggleDetails(this)">
                            <i class="fa fa-arrow-down"></i>
                        </button>
                    </td>
                </tr>
                <tr class="details-row">
                    <td colspan="8" class="p-0">
                        <div class="js-order-details">
                            <div class="p-3 table-details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Order #<?= htmlspecialchars($order->id ?? '', ENT_QUOTES) ?></h4>
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4">Delivery Address</dt>
                                            <dd class="col-sm-8"><?= htmlspecialchars($order->delivery_address ?? 'N/A', ENT_QUOTES) ?></dd>

                                            <dt class="col-sm-4">State/Country</dt>
                                            <dd class="col-sm-8">
                                                <?= htmlspecialchars(($order->state ?? '') . '/' . ($order->country ?? ''), ENT_QUOTES) ?>
                                            </dd>

                                            <dt class="col-sm-4">Postal Code</dt>
                                            <dd class="col-sm-8"><?= htmlspecialchars($order->postal_code ?? 'N/A', ENT_QUOTES) ?></dd>
                                        </dl>
                                    </div>

                                    <div class="col-md-6">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4">Phone</dt>
                                            <dd class="col-sm-8"><?= htmlspecialchars($order->phone_number ?? 'N/A', ENT_QUOTES) ?></dd>

                                            <dt class="col-sm-4">Order Date</dt>
                                            <dd class="col-sm-8"><?= date("jS M Y H:i a", strtotime($order->date)) ?></dd>
                                        </dl>
                                    </div>
                                </div>

                                <hr>

                                <h5>Order Summary</h5>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($order->details) && is_array($order->details)): ?>
                                            <?php foreach ($order->details as $detail): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($detail->qty ?? 0, ENT_QUOTES) ?></td>
                                                    <td><?= htmlspecialchars($detail->description ?? 'N/A', ENT_QUOTES) ?></td>
                                                    <td>R <?= number_format($detail->amount ?? 0, 2) ?></td>
                                                    <td>R <?= number_format($detail->total ?? 0, 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No order details found</td>
                                            </tr>
                                        <?php endif; ?>

                                    </tbody>
                                </table>

                                <div class="text-end">
                                    <h5>Grand Total: R <?= number_format($order->grand_total ?? 0, 2) ?></h5>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="8"><?php Page::show_links(); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function toggleDetails(btn) {
        const row = btn.closest('tr');
        const detailsRow = row.nextElementSibling;
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';

        // Toggle aria state
        btn.setAttribute('aria-expanded', !isExpanded);

        // Toggle details visibility
        detailsRow.querySelector('.js-order-details').style.display = isExpanded ? 'none' : 'block';

        // Close other open details
        document.querySelectorAll('[aria-expanded="true"]').forEach(otherBtn => {
            if (otherBtn !== btn) {
                otherBtn.setAttribute('aria-expanded', 'false');
                otherBtn.closest('tr').nextElementSibling.querySelector('.js-order-details').style.display = 'none';
            }
        });
    }
</script>

<?php $this->view("admin/footer", $data); ?>