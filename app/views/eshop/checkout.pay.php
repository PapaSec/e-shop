<?php $this->view("header", $data); ?>

<div class="container" style="text-align: center; padding: 80px 20px; max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 40px;">
        <i class="fa fa-check-circle fa-5x" style="color: #28a745; font-size: 60px; margin-bottom: 20px;"></i>
        <h1 class="mb-3">Select a payment below</h1>
    </div>
</div>

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
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    //alert('Transaction completed by ' + details.payer.name.given_name + '!');
                    window.location.href = '<?= ROOT . "thanks?mode=approved" ?>';
                });
            },

            onCancel: function(data) {
                window.location.href = '<?= ROOT . "thanks?mode=cancel" ?>';
            },
            onError: function(err) {
                window.location.href = '<?= ROOT . "thanks?mode=error" ?>';
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>

<br><br>

<?php $this->view("footer", $data); ?>