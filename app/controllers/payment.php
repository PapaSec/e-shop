<?php

class Payment extends Controller
{
    public function index()
    {
        // Read raw POST data from Payfast ITN
        $data = file_get_contents("php://input");
        $pfData = $_POST; // Payfast sends data as POST

        // Log the ITN data for debugging (optional, remove in production)
        $filename = time() . "_payfast_itn.txt";
        file_put_contents($filename, print_r($pfData, true));

        // Validate the ITN
        if ($this->validatePayfastITN($pfData)) {
            // Extract relevant data
            $orderId = $pfData['m_payment_id']; // You can use this to link to your order
            $paymentStatus = $pfData['payment_status'];
            $amountGross = $pfData['amount_gross'];

            // Load the Order model
            $orderModel = $this->load_model('Order');

            // Update order status based on payment status
            if ($paymentStatus === 'COMPLETE') {
                // Update order status to 'paid' in your database
                $db = Database::newInstance();
                $query = "UPDATE orders SET status = 'paid' WHERE id = :order_id";
                $db->write($query, ['order_id' => $orderId]);

                // Optionally, clear cart and session data
                unset($_SESSION['CART']);
                unset($_SESSION['POST_DATA']);
            } else {
                // Handle failed or cancelled payments
                $db = Database::newInstance();
                $query = "UPDATE orders SET status = 'failed' WHERE id = :order_id";
                $db->write($query, ['order_id' => $orderId]);
            }
        } else {
            // Invalid ITN, log for investigation
            file_put_contents($filename . "_invalid", "Invalid ITN received");
        }

        // Respond with 200 OK to Payfast
        header('HTTP/1.1 200 OK');
    }

    private function validatePayfastITN($pfData)
    {
        // Payfast ITN validation steps
        $pfHost = (getenv('APP_ENV') === 'production') ? 'www.payfast.co.za' : 'sandbox.payfast.co.za';
        $merchantId = '10038712'; // Your Merchant ID
        $merchantKey = 'k3574bcwibn8l'; // Your Merchant Key

        // Step 1: Verify the signature
        $signature = $pfData['signature'];
        unset($pfData['signature']);
        $pfParamString = '';
        foreach ($pfData as $key => $val) {
            if ($key !== 'signature' && $val !== '') {
                $pfParamString .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        $pfParamString = substr($pfParamString, 0, -1);
        $checkSignature = md5($pfParamString);
        if ($signature !== $checkSignature) {
            return false;
        }

        // Step 2: Check if the payment status is valid
        if (!isset($pfData['payment_status']) || $pfData['payment_status'] !== 'COMPLETE') {
            return false;
        }

        // Step 3: Verify the data with Payfast server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://$pfHost/eng/query/validate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pfData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return strpos($response, 'VALID') !== false;
    }
}
