<?php

class Payment extends Controller
{
    public function index()
    {
        // Enable error logging for debugging
        ini_set('log_errors', 1);
        ini_set('error_log', 'C:/xampp/htdocs/e-shop/paypal_errors.log');

        // Get the actual payload
        $rawData = file_get_contents('php://input');
        if (empty($rawData)) {
            error_log("No payload received at " . date('Y-m-d H:i:s') . " - Server variables: " . json_encode($_SERVER));
            http_response_code(400);
            die("No payload received");
        }

        // Log the raw payload and server environment
        error_log("Raw Payload Received at " . date('Y-m-d H:i:s') . ": " . $rawData);
        error_log("Server Environment: " . json_encode($_SERVER));

        // Decode the payload
        $obj = json_decode($rawData);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON Decode Error: " . json_last_error_msg() . " at " . date('Y-m-d H:i:s') . " - Raw Data: " . $rawData);
            http_response_code(400);
            die("Invalid JSON payload");
        }

        $DB = Database::newInstance();

        if (is_object($obj)) {
            $arr = array();
            $arr['raw'] = $rawData;
            $arr['date'] = date('Y-m-d H:i:s');

            // Extract PayPal Order ID for linking events
            $paypal_order_id = '';
            $should_insert = true;

            // Check if this is a webhook event or an onApprove payload
            if (isset($obj->event_type)) {
                error_log("Webhook Event Received: " . $obj->event_type . " at " . date('Y-m-d H:i:s'));
                $arr['trans_id'] = $obj->id ?? '';
                $arr['event_type'] = $obj->event_type ?? '';
                $paypal_order_id = $obj->resource->id ?? '';

                if ($obj->event_type === 'CHECKOUT.ORDER.APPROVED') {
                    $purchase_unit = $obj->resource->purchase_units[0] ?? null;
                    if ($purchase_unit) {
                        $arr['amount'] = $purchase_unit->amount->value ?? 0;
                        $arr['order_id'] = $purchase_unit->description ?? '';
                        $arr['status'] = $obj->resource->status ?? 'APPROVED';
                        $arr['summary'] = $obj->summary ?? '';
                        $arr['email_address'] = $purchase_unit->payee->email_address ?? '';
                        $arr['merchant_id'] = $purchase_unit->payee->merchant_id ?? '';
                        $arr['first_name'] = $obj->resource->payer->name->given_name ?? '';
                        $arr['last_name'] = $obj->resource->payer->name->surname ?? '';
                    }
                } elseif ($obj->event_type === 'PAYMENT.CAPTURE.COMPLETED') {
                    $arr['trans_id'] = $obj->resource->id ?? '';
                    $arr['amount'] = $obj->resource->amount->value ?? 0;
                    $arr['order_id'] = $obj->resource->supplementary_data->related_ids->order_id ?? '';
                    $arr['status'] = $obj->resource->status ?? '';
                    $arr['summary'] = $obj->summary ?? '';
                    $arr['email_address'] = $obj->resource->payee->email_address ?? '';
                    $arr['merchant_id'] = $obj->resource->payee->merchant_id ?? '';
                    $arr['first_name'] = $obj->resource->payer->name->given_name ?? '';
                    $arr['last_name'] = $obj->resource->payer->name->surname ?? '';
                    $paypal_order_id = $obj->resource->supplementary_data->related_ids->order_id ?? '';
                } else {
                    error_log("Unsupported event type: " . ($obj->event_type ?? 'unknown') . " at " . date('Y-m-d H:i:s'));
                    http_response_code(400);
                    die("Unsupported event type");
                }
            } else {
                error_log("Processing onApprove payload at " . date('Y-m-d H:i:s'));
                $arr['event_type'] = 'ONAPPROVE_CAPTURE';
                $arr['trans_id'] = $obj->id ?? '';
                $paypal_order_id = $obj->id ?? '';

                $purchase_unit = $obj->purchase_units[0] ?? null;
                if ($purchase_unit) {
                    if (isset($purchase_unit->payments->captures) && is_array($purchase_unit->payments->captures) && count($purchase_unit->payments->captures) > 0) {
                        $capture = $purchase_unit->payments->captures[0];
                        $arr['trans_id'] = $capture->id ?? $arr['trans_id'];
                        $arr['amount'] = $capture->amount->value ?? 0;
                        $arr['status'] = $capture->status ?? 'UNKNOWN';
                    } else {
                        $arr['event_type'] = 'ONAPPROVE_APPROVED';
                        $arr['amount'] = $purchase_unit->amount->value ?? 0;
                        $arr['status'] = 'APPROVED';
                    }
                    $arr['order_id'] = $purchase_unit->description ?? '';
                    $arr['summary'] = $arr['status'] === 'APPROVED' ? 'Order approved via onApprove (webhook missing)' : 'Payment captured via onApprove';
                    $arr['email_address'] = $purchase_unit->payee->email_address ?? '';
                    $arr['merchant_id'] = $purchase_unit->payee->merchant_id ?? '';
                }
                $arr['first_name'] = $obj->payer->name->given_name ?? '';
                $arr['last_name'] = $obj->payer->name->surname ?? '';
                $arr['email_address'] = $obj->payer->email_address ?? ($arr['email_address'] ?? '');

                // Check for existing CHECKOUT.ORDER.APPROVED
                if ($paypal_order_id) {
                    $check_query = "SELECT id, event_type, status FROM payments WHERE paypal_order_id = :paypal_order_id LIMIT 1";
                    $check_result = $DB->read($check_query, ['paypal_order_id' => $paypal_order_id]);
                    if (is_array($check_result) && count($check_result) > 0) {
                        $existing_event_type = $check_result[0]->event_type;
                        if ($existing_event_type === 'CHECKOUT.ORDER.APPROVED' || $existing_event_type === 'ONAPPROVE_APPROVED') {
                            $should_insert = false;
                        }
                    }
                }
            }

            // Set paypal_order_id in the array
            $arr['paypal_order_id'] = $paypal_order_id;

            // Log the data being inserted/updated
            error_log("Payment Data to Process: " . json_encode($arr));

            // Check for existing record with the same paypal_order_id
            if ($paypal_order_id) {
                $check_query = "SELECT id, event_type, status FROM payments WHERE paypal_order_id = :paypal_order_id LIMIT 1";
                $check_result = $DB->read($check_query, ['paypal_order_id' => $paypal_order_id]);
                if (is_array($check_result) && count($check_result) > 0) {
                    $existing_event_type = $check_result[0]->event_type;
                    $existing_status = $check_result[0]->status;

                    if ($arr['event_type'] === 'CHECKOUT.ORDER.APPROVED') {
                        $update_query = "UPDATE payments SET trans_id = :trans_id, event_type = :event_type, amount = :amount, order_id = :order_id, status = :status, summary = :summary, email_address = :email_address, merchant_id = :merchant_id, first_name = :first_name, last_name = :last_name, raw = :raw, date = :date WHERE paypal_order_id = :paypal_order_id";
                        $result = $DB->write($update_query, $arr);
                        if (!$result) {
                            error_log("Failed to update payment for paypal_order_id: " . $paypal_order_id . " at " . date('Y-m-d H:i:s'));
                            http_response_code(500);
                            die("Database update failed");
                        }
                        error_log("Updated payment for paypal_order_id: " . $paypal_order_id . " with CHECKOUT.ORDER.APPROVED");
                        http_response_code(200);
                        die("Updated existing payment");
                    } elseif (($existing_event_type === 'CHECKOUT.ORDER.APPROVED' || $existing_event_type === 'ONAPPROVE_APPROVED') && ($arr['event_type'] === 'PAYMENT.CAPTURE.COMPLETED' || $arr['event_type'] === 'ONAPPROVE_CAPTURE')) {
                        $update_query = "UPDATE payments SET trans_id = :trans_id, event_type = :event_type, amount = :amount, status = :status, summary = :summary, raw = :raw, date = :date WHERE paypal_order_id = :paypal_order_id";
                        $result = $DB->write($update_query, $arr);
                        if (!$result) {
                            error_log("Failed to update payment for paypal_order_id: " . $paypal_order_id . " at " . date('Y-m-d H:i:s'));
                            http_response_code(500);
                            die("Database update failed");
                        }
                        error_log("Updated payment for paypal_order_id: " . $paypal_order_id . " with capture event");
                        http_response_code(200);
                        die("Updated existing payment");
                    } else {
                        error_log("Duplicate payment for paypal_order_id: " . $paypal_order_id . " with event_type: " . $existing_event_type);
                        http_response_code(200);
                        die("Duplicate payment");
                    }
                }
            }

            if ($should_insert) {
                $query = "INSERT INTO payments 
                    (trans_id, event_type, amount, order_id, status, summary, email_address, merchant_id, first_name, last_name, raw, date, paypal_order_id) 
                    VALUES (:trans_id, :event_type, :amount, :order_id, :status, :summary, :email_address, :merchant_id, :first_name, :last_name, :raw, :date, :paypal_order_id)";

                $result = $DB->write($query, $arr);
                if (!$result) {
                    error_log("Failed to insert payment into database: " . json_encode($arr) . " at " . date('Y-m-d H:i:s'));
                    http_response_code(500);
                    die("Database insertion failed");
                }
                error_log("Payment recorded successfully: " . $arr['trans_id'] . " at " . date('Y-m-d H:i:s'));
            }
        } else {
            error_log("Invalid payload: Not an object at " . date('Y-m-d H:i:s') . " - Raw Data: " . $rawData);
            http_response_code(400);
            die("Invalid payload");
        }

        http_response_code(200);
        die("Processed successfully");
    }
}
