<?php

class Payment extends Controller
{
    public function index()
    {
        // $User = $this->load_model("User");

        $data = file_get_contents("php://input");
        $data = '{"id":"WH-7FK535878K2751108-03R660163S427435M","create_time":"2025-05-13T20:44:45.231Z","resource_type":"checkout-order","event_type":"CHECKOUT.ORDER.APPROVED","summary":"An order has been approved by buyer","resource":{"create_time":"2025-05-13T20:43:18Z","purchase_units":[{"reference_id":"default","amount":{"currency_code":"USD","value":"8.00","breakdown":{"item_total":{"currency_code":"USD","value":"6.00"},"shipping":{"currency_code":"USD","value":"2.00"},"tax_total":{"currency_code":"USD","value":"0.00"}}},"payee":{"email_address":"sb-j1xdm41391115@business.example.com","merchant_id":"UFX4P9PWYZC4G"},"description":"My description","shipping":{"name":{"full_name":"Ronnie Doe"},"address":{"address_line_1":"805 Timol Street","address_line_2":"Dobsonville Gardens","admin_area_2":"TAUNG","postal_code":"1865","country_code":"ZA"}}}],"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1XP88460UL4878459","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1XP88460UL4878459","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1XP88460UL4878459/capture","rel":"capture","method":"POST"}],"id":"1XP88460UL4878459","payment_source":{"paypal":{"email_address":"sb-ororv41401714@personal.example.com","account_id":"8EBBESUNWGD4N","account_status":"VERIFIED","name":{"given_name":"Ronnie","surname":"Doe"},"address":{"country_code":"ZA"}}},"intent":"CAPTURE","payer":{"name":{"given_name":"Ronnie","surname":"Doe"},"email_address":"sb-ororv41401714@personal.example.com","payer_id":"8EBBESUNWGD4N","address":{"country_code":"ZA"}},"status":"APPROVED"},"status":"SUCCESS","transmissions":[{"webhook_url":"https://e-shop.infy.uk/public/payment","http_status":200,"reason_phrase":"OK","response_headers":{"Cache-Control":"no-cache","Server":"openresty","Connection":"keep-alive","Expires":"Thu, 01 Jan 1970 00:00:01 GMT","Content-Length":"855","Date":"Tue, 13 May 2025 20:44:57 GMT","Content-Type":"text/html"},"transmission_id":"1f5f2c2d-303b-11f0-ae33-35edc705cd62","status":"SUCCESS","timestamp":"2025-05-13T20:44:53Z"}],"links":[{"href":"https://api.sandbox.paypal.com/v1/notifications/webhooks-events/WH-7FK535878K2751108-03R660163S427435M","rel":"self","method":"GET","encType":"application/json"},{"href":"https://api.sandbox.paypal.com/v1/notifications/webhooks-events/WH-7FK535878K2751108-03R660163S427435M/resend","rel":"resend","method":"POST","encType":"application/json"}],"event_version":"1.0","resource_version":"2.0"}';

        //$filename = time() . "_txt";
        //file_put_contents($filename, $data);

        $obj = json_decode($data);

        $DB = Database::newInstance();

        if (is_object($obj)) {

            $arr = array();
            $arr['trans_id']        = $obj->id;
            $arr['event_type']      = $obj->event_type;
            $arr['amount']          = $obj->resource->purchase_units[0]->amount->value;
            $arr['order_id']        = $obj->resource->purchase_units[0]->description;
            $arr['status']          = $obj->resource->status;
            $arr['summary']         = $obj->summary;
            $arr['email_address']   = $obj->resource->purchase_units[0]->payee->email_address;
            $arr['merchant_id']     = $obj->resource->purchase_units[0]->payee->merchant_id;
            $arr['first_name']      = $obj->resource->payer->name->given_name;
            $arr['last_name']       = $obj->resource->payer->name->surname;
            $arr['raw']             = $data;
            $arr['date']            = date('Y-m-d H:i:s');

            $query = "INSERT INTO payments 
                (trans_id,event_type,amount,order_id,status,summary,email_address,merchant_id,first_name,last_name,raw,date) 
                values (:trans_id,:event_type,:amount,:order_id,:status,:summary,:email_address,:merchant_id,:first_name,:last_name,:raw,:date)";

            $DB->write($query, $arr);
        }
    }
}
