<?php $this->view("header", $data); ?>

<?php

if (isset($_SESSION['POST_DATA'])) {
    $total = 0;
    $description = "order 0";
    extract($_SESSION['POST_DATA']);
}

?>

<div class="payment-container" style="display: flex; justify-content: center; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #f0f4f8 0%, #d9e4f5 100%);">
    <div class="payment-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); max-width: 500px; width: 100%; text-align: center; transition: transform 0.3s ease; margin: 20px auto;">
        <div style="margin-bottom: 20px;">
            <i class="fa fa-check-circle" style="color: #28a745; font-size: 50px; margin-bottom: 15px; animation: bounceIn 1s ease;"></i>
            <h1 style="color: #2c3e50; font-family: 'Arial', sans-serif; font-weight: 700; font-size: 1.8rem; margin-bottom: 10px; letter-spacing: 0.5px;">Choose Your Payment Method</h1>
            <p style="color: #7f8c8d; font-size: 1rem; line-height: 1.5; margin-bottom: 0;">Securely complete your purchase with the option below.</p>
        </div>

        <div id="smart-button-container" style="margin-top: 15px;">
            <div style="padding: 10px; background: #f8f9fa; border-radius: 10px; box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);">
                <div id="paypal-button-container" style="margin: 0 auto;"></div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounceIn {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.5;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 600px) {
        .payment-card {
            padding: 20px;
            margin: 10px auto;
        }

        h1 {
            font-size: 1.4rem;
        }

        p {
            font-size: 0.9rem;
        }
    }

    /* Reduce bottom spacing */
    body {
        margin-bottom: 0;
    }

    footer {
        margin-top: 0;
        padding-top: 10px;
    }
</style>

<script src="https://www.paypal.com/sdk/js?client-id=AV8oS88hOSLruLO2qT7t0x4bqLyzOALsxuW8Hvnk3Z2iYKb_pSR07RtJcbtsc_3p6w3bMR3qDyV1nS0B"></script>

<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',
                height: 45, // Reduced height for compactness
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "<?= $description ?>",
                        "amount": {
                            currency_code: "USD",
                            value: "<?= $total ?>",
                            breakdown: {
                                item_total: {
                                    currency_code: "USD",
                                    value: "<?= $total ?>"
                                },
                                shipping: {
                                    currency_code: "USD",
                                    value: 0
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
                    window.location.href = '<?= ROOT . "thanks?mode=approved&name=" . urlencode("{details.payer.name.given_name}") ?>'.replace("{details.payer.name.given_name}", encodeURIComponent(details.payer.name.given_name));
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

<?php $this->view("footer", $data); ?>