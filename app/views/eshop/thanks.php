<?php $this->view("header", $data); ?>

<?php $this->view("slider", $data); ?>

<?php

// For demonstration purposes, we are using a hardcoded JSON string.
//$str = '{"id":"WH-7FK535878K2751108-03R660163S427435M","create_time":"2025-05-13T20:44:45.231Z","resource_type":"checkout-order","event_type":"CHECKOUT.ORDER.APPROVED","summary":"An order has been approved by buyer","resource":{"create_time":"2025-05-13T20:43:18Z","purchase_units":[{"reference_id":"default","amount":{"currency_code":"USD","value":"8.00","breakdown":{"item_total":{"currency_code":"USD","value":"6.00"},"shipping":{"currency_code":"USD","value":"2.00"},"tax_total":{"currency_code":"USD","value":"0.00"}}},"payee":{"email_address":"sb-j1xdm41391115@business.example.com","merchant_id":"UFX4P9PWYZC4G"},"description":"My description","shipping":{"name":{"full_name":"Ronnie Doe"},"address":{"address_line_1":"805 Timol Street","address_line_2":"Dobsonville Gardens","admin_area_2":"TAUNG","postal_code":"1865","country_code":"ZA"}}}],"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1XP88460UL4878459","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1XP88460UL4878459","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1XP88460UL4878459/capture","rel":"capture","method":"POST"}],"id":"1XP88460UL4878459","payment_source":{"paypal":{"email_address":"sb-ororv41401714@personal.example.com","account_id":"8EBBESUNWGD4N","account_status":"VERIFIED","name":{"given_name":"Ronnie","surname":"Doe"},"address":{"country_code":"ZA"}}},"intent":"CAPTURE","payer":{"name":{"given_name":"Ronnie","surname":"Doe"},"email_address":"sb-ororv41401714@personal.example.com","payer_id":"8EBBESUNWGD4N","address":{"country_code":"ZA"}},"status":"APPROVED"},"status":"SUCCESS","transmissions":[{"webhook_url":"https://e-shop.infy.uk/public/payment","http_status":200,"reason_phrase":"OK","response_headers":{"Cache-Control":"no-cache","Server":"openresty","Connection":"keep-alive","Expires":"Thu, 01 Jan 1970 00:00:01 GMT","Content-Length":"855","Date":"Tue, 13 May 2025 20:44:57 GMT","Content-Type":"text/html"},"transmission_id":"1f5f2c2d-303b-11f0-ae33-35edc705cd62","status":"SUCCESS","timestamp":"2025-05-13T20:44:53Z"}],"links":[{"href":"https://api.sandbox.paypal.com/v1/notifications/webhooks-events/WH-7FK535878K2751108-03R660163S427435M","rel":"self","method":"GET","encType":"application/json"},{"href":"https://api.sandbox.paypal.com/v1/notifications/webhooks-events/WH-7FK535878K2751108-03R660163S427435M/resend","rel":"resend","method":"POST","encType":"application/json"}],"event_version":"1.0","resource_version":"2.0"}';

//echo "<pre>";
//$obj = json_decode($str);

// Print the entire object for debugging
//print_r($obj);

?>

<?php
// Initialize $paymentStatus based on the 'mode' query parameter
$paymentStatus = "error"; // Default to error as a fallback
if (isset($_GET['mode'])) {
    switch ($_GET['mode']) {
        case 'approved':
            $paymentStatus = "success";
            break;
        case 'cancel':
            $paymentStatus = "canceled";
            break;
        case 'error':
            $paymentStatus = "error";
            break;
    }
}
?>

<section>
    <div class="container">
        <div class="row">
            <?php if ($paymentStatus === "success"): ?>
                <div style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
                            padding: 3rem; 
                            border-radius: 15px; 
                            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
                            text-align: center;
                            max-width: 800px;
                            margin: 2rem auto;
                            border-left: 5px solid #4e73df;">
                    <h1 style="color: #2d3748; 
                               font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                               font-weight: 600;
                               margin-bottom: 1rem;">
                        Thank You for Shopping With Us! 💙
                    </h1>
                    <p style="color: #4a5568; 
                              font-size: 1.1rem;
                              line-height: 1.6;">
                        We appreciate your business! Your order is being processed and you'll receive a confirmation shortly.
                    </p>
                    <div style="margin-top: 2rem;">
                        <a href="<?= ROOT ?>shop" style="background: #4e73df;
                                  color: white;
                                  padding: 12px 24px;
                                  border-radius: 50px;
                                  text-decoration: none;
                                  font-weight: 500;
                                  display: inline-block;
                                  transition: all 0.3s ease;">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            <?php elseif ($paymentStatus === "canceled"): ?>
                <div style="background: linear-gradient(135deg, #f5f7fa 0%, #d3d9e5 100%); 
                            padding: 3rem; 
                            border-radius: 15px; 
                            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
                            text-align: center;
                            max-width: 800px;
                            margin: 2rem auto;
                            border-left: 5px solid #f1c40f;">
                    <h1 style="color: #2d3748; 
                               font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                               font-weight: 600;
                               margin-bottom: 1rem;">
                        Payment Canceled 💛
                    </h1>
                    <p style="color: #4a5568; 
                              font-size: 1.1rem;
                              line-height: 1.6;">
                        It looks like you canceled your payment. No worries! You can try again or continue shopping.
                    </p>
                    <div style="margin-top: 2rem;">
                        <a href="<?= ROOT ?>shop" style="background: #f1c40f;
                                  color: white;
                                  padding: 12px 24px;
                                  border-radius: 50px;
                                  text-decoration: none;
                                  font-weight: 500;
                                  display: inline-block;
                                  transition: all 0.3s ease;
                                  margin-right: 10px;">
                            Continue Shopping
                        </a>
                        <a href="<?= ROOT ?>checkout" style="background: #6c757d;
                                  color: white;
                                  padding: 12px 24px;
                                  border-radius: 50px;
                                  text-decoration: none;
                                  font-weight: 500;
                                  display: inline-block;
                                  transition: all 0.3s ease;">
                            Try Again
                        </a>
                    </div>
                </div>
            <?php elseif ($paymentStatus === "error"): ?>
                <div style="background: linear-gradient(135deg, #f5f7fa 0%, #e3c8c8 100%); 
                            padding: 3rem; 
                            border-radius: 15px; 
                            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
                            text-align: center;
                            max-width: 800px;
                            margin: 2rem auto;
                            border-left: 5px solid #e74c3c;">
                    <h1 style="color: #2d3748; 
                               font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                               font-weight: 600;
                               margin-bottom: 1rem;">
                        Oops, Something Went Wrong! ❤️
                    </h1>
                    <p style="color: #4a5568; 
                              font-size: 1.1rem;
                              line-height: 1.6;">
                        We encountered an error while processing your payment. Please try again or contact support if the issue persists.
                    </p>
                    <div style="margin-top: 2rem;">
                        <a href="<?= ROOT ?>checkout" style="background: #e74c3c;
                                  color: white;
                                  padding: 12px 24px;
                                  border-radius: 50px;
                                  text-decoration: none;
                                  font-weight: 500;
                                  display: inline-block;
                                  transition: all 0.3s ease;
                                  margin-right: 10px;">
                            Try Again
                        </a>
                        <a href="<?= ROOT ?>contact" style="background: #6c757d;
                                  color: white;
                                  padding: 12px 24px;
                                  border-radius: 50px;
                                  text-decoration: none;
                                  font-weight: 500;
                                  display: inline-block;
                                  transition: all 0.3s ease;">
                            Contact Support
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $this->view("footer", $data); ?>