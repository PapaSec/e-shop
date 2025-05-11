<?php

class Checkout extends Controller
{
    public function index()
    {

        $User = $this->load_model("User");
        $image_class = $this->load_model("Image");
        $user_data = $User->check_login();

        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();
        $ROWS = false;
        $prod_ids = array();
        if (isset($_SESSION['CART'])) {
            $prod_ids = array_column($_SESSION['CART'], 'id');
            $ids_str = "'" . implode("','", $prod_ids) . "'";

            $ROWS = $DB->read("select * from products where id in ($ids_str)");
        }


        if (is_array($ROWS)) {
            foreach ($ROWS as $key => $row) {

                foreach ($_SESSION['CART'] as $item) {

                    if ($row->id == $item['id']) {
                        $ROWS[$key]->cart_qty =  $item['qty'];
                        break;
                    }
                }
            }
        }

        $data['page_title'] = "Checkout";
        $data['sub_total'] = 0;

        if ($ROWS) {
            foreach ($ROWS as $key => $row) {
                $ROWS[$key]->image = $image_class->get_thumb_post($ROWS[$key]->image);
                $mytotal = $row->price * $row->cart_qty;

                $data['sub_total'] += $mytotal;
            }
        }

        if (is_array($ROWS)) {
            rsort($ROWS);
        }

        $data['ROWS'] = $ROWS;

        // Get Countries
        $countries = $this->load_model('Countries');
        $data['countries'] = $countries->get_countries();

        // check if the old input data exists
        if (isset($_SESSION['POST_DATA'])) {
            $data['POST_DATA'] = $_SESSION['POST_DATA'];
        }

        if (count($_POST) > 0) {

            $order = $this->load_model('Order');
            $order->validate($_POST);
            $data['errors'] = $order->errors;

            $_SESSION['POST_DATA'] = $_POST;
            $data['POST_DATA'] = $_POST;

            if (count($order->errors) == 0) {
                header("Location:" . ROOT . "checkout/summary");
                die;
            }
        }
        $this->view("checkout", $data);
    }

    public function summary()
    {
        $User = $this->load_model("User");
        $image_class = $this->load_model("Image");
        $user_data = $User->check_login();

        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }

        // Get data from the cart
        $DB = Database::newInstance();
        $ROWS = false;
        $prod_ids = array();
        if (isset($_SESSION['CART'])) {
            $prod_ids = array_column($_SESSION['CART'], 'id');
            $ids_str = "'" . implode("','", $prod_ids) . "'";

            $ROWS = $DB->read("select * from products where id in ($ids_str)");
        }

        if (is_array($ROWS)) {
            foreach ($ROWS as $key => $row) {
                foreach ($_SESSION['CART'] as $item) {
                    if ($row->id == $item['id']) {
                        $ROWS[$key]->cart_qty = $item['qty'];
                        break;
                    }
                }
            }
        }

        $data['sub_total'] = 0;
        if ($ROWS) {
            foreach ($ROWS as $key => $row) {
                $mytotal = $row->price * $row->cart_qty;
                $data['sub_total'] += $mytotal;
            }
        }

        $data['order_details'] = $ROWS;
        $data['orders'][] = $_SESSION['POST_DATA'] ?? [];
        $data['page_title'] = "Checkout - Summary";

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['POST_DATA'])) {
            $sessionid = session_id();
            $user_url = isset($_SESSION['user_url']) ? $_SESSION['user_url'] : '';

            $order = $this->load_model('Order');
            $order->save_order($_SESSION['POST_DATA'], $ROWS, $user_url, $sessionid);
            $data['errors'] = $order->errors;

            if (empty($order->errors)) {
                // Get the latest order ID
                $db = Database::newInstance();
                $query = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
                $result = $db->read($query);
                $orderId = $result[0]->id ?? null;

                if ($orderId) {
                    // Generate Payfast payment request
                    $uuid = $this->generatePayfastPayment($orderId, $data['sub_total'], $user_data);
                    if ($uuid) {
                        // Store UUID in session
                        $_SESSION['payfast_uuid'] = $uuid;
                        // Log success for debugging
                        file_put_contents('payfast_success_' . time() . '.log', 'UUID generated: ' . $uuid);
                    } else {
                        $data['errors'][] = "Failed to initiate payment with Payfast.";
                        file_put_contents('payfast_error_' . time() . '.log', 'UUID generation failed for order ID: ' . $orderId);
                    }
                } else {
                    $data['errors'][] = "Failed to retrieve order ID.";
                    file_put_contents('payfast_error_' . time() . '.log', 'No order ID retrieved');
                }
            } else {
                file_put_contents('payfast_error_' . time() . '.log', 'Order save errors: ' . print_r($order->errors, true));
            }
        }

        $this->view("checkout.summary", $data);
    }

    private function generatePayfastPayment($orderId, $amount, $user_data)
    {
        $merchantId = '10038712';
        $merchantKey = 'k3574bcwibn8l';
        $passPhrase = 'jt7NOE43FZPn';
        $isSandbox = true; // Set to false in production
        $returnUrl = ROOT . 'checkout/thank_you';
        $cancelUrl = ROOT . 'checkout/summary';
        $notifyUrl = ROOT . 'payment';

        $data = [
            'merchant_id' => $merchantId,
            'merchant_key' => $merchantKey,
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'notify_url' => $notifyUrl,
            'm_payment_id' => $orderId,
            'amount' => number_format($amount, 2, '.', ''),
            'item_name' => 'Order #' . $orderId,
            'item_description' => 'Payment for order #' . $orderId,
        ];

        // Add user details if available
        if ($user_data) {
            $data['email_address'] = $user_data->email ?? '';
            $data['name_first'] = $user_data->first_name ?? '';
            $data['name_last'] = $user_data->last_name ?? '';
        }

        // Generate signature
        ksort($data); // Sort data by keys to ensure consistent signature
        $pfParamString = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfParamString .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        $pfParamString = substr($pfParamString, 0, -1);
        $data['signature'] = md5($pfParamString . '&passphrase=' . urlencode($passPhrase));

        // Convert data to string for Payfast API
        $pfParamString = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfParamString .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        $pfParamString = substr($pfParamString, 0, -1);

        // Log the request data for debugging
        file_put_contents('payfast_request_' . time() . '.log', $pfParamString);

        // Send request to Payfast
        $url = $isSandbox ? 'https://sandbox.payfast.co.za/onsite/process' : 'https://www.payfast.co.za/onsite/process';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pfParamString);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; YourApp)');
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = 'cURL Error: ' . curl_error($ch);
            file_put_contents('payfast_error_' . time() . '.log', $error);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        // Log the response
        file_put_contents('payfast_response_' . time() . '.log', $response);

        $rsp = json_decode($response, true);
        if (isset($rsp['uuid'])) {
            return $rsp['uuid'];
        } else {
            file_put_contents('payfast_error_' . time() . '.log', 'No UUID in response: ' . print_r($rsp, true));
            return null;
        }
    }

    public function thank_you()
    {
        $data['page_title'] = "Thank You";
        $this->view("checkout.thank_you", $data);
    }
}
