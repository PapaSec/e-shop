<?php

class Payment extends Controller
{
    public function index()
    {
        // Enable error logging for debugging
        ini_set('log_errors', 1);
        ini_set('error_log', 'C:/xampp/htdocs/e-shop/paypal_errors.log');

        // Get the actual webhook payload
        $data = file_get_contents("php://input");
        if (empty($data)) {
            error_log("No webhook payload received at " . date('Y-m-d H:i:s'));
            http_response_code(400);
            die("No payload received");
        }

        // Log the raw webhook data for debugging
        error_log("Webhook Payload Received: " . $data);

        // Decode the payload
        $obj = json_decode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON Decode Error: " . json_last_error_msg() . " at " . date('Y-m-d H:i:s'));
            http_response_code(400);
            die("Invalid JSON payload");
        }

        $DB = Database::newInstance();

        if (is_object($obj)) {
            $arr = array();
            $arr['trans_id'] = $obj->id ?? '';
            $arr['event_type'] = $obj->event_type ?? '';
            $arr['amount'] = $obj->resource->purchase_units[0]->amount->value ?? 0;
            $arr['order_id'] = $obj->resource->purchase_units[0]->description ?? '';
            $arr['status'] = $obj->resource->status ?? '';
            $arr['summary'] = $obj->summary ?? '';
            $arr['email_address'] = $obj->resource->purchase_units[0]->payee->email_address ?? '';
            $arr['merchant_id'] = $obj->resource->purchase_units[0]->payee->merchant_id ?? '';
            $arr['first_name'] = $obj->resource->payer->name->given_name ?? '';
            $arr['last_name'] = $obj->resource->payer->name->surname ?? '';
            $arr['raw'] = $data;
            $arr['date'] = date('Y-m-d H:i:s');

            $query = "INSERT INTO payments 
                (trans_id, event_type, amount, order_id, status, summary, email_address, merchant_id, first_name, last_name, raw, date) 
                VALUES (:trans_id, :event_type, :amount, :order_id, :status, :summary, :email_address, :merchant_id, :first_name, :last_name, :raw, :date)";

            $result = $DB->write($query, $arr);
            if (!$result) {
                error_log("Failed to insert payment into database: " . json_encode($arr) . " at " . date('Y-m-d H:i:s'));
                http_response_code(500);
                die("Database insertion failed");
            }

            // Log success
            error_log("Payment recorded successfully: " . $arr['trans_id'] . " at " . date('Y-m-d H:i:s'));
        } else {
            error_log("Invalid webhook payload: Not an object at " . date('Y-m-d H:i:s'));
            http_response_code(400);
            die("Invalid payload");
        }

        // Respond with 200 OK to acknowledge the webhook
        http_response_code(200);
        die("Webhook processed successfully");
    }
}
