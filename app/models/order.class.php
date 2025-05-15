<?php

class Order extends Controller
{
    public $errors = array();

    public function validate($POST)
    {
        $this->errors = array();
        foreach ($POST as $key => $value) {

            if ($key == "country") {
                if ($value == "" || $value == "-- Country --") {
                    $this->errors[] = "Please select a country";
                }
            }

            if ($key == "state") {
                if ($value == "" || $value == "-- State / Province / Region --") {
                    $this->errors[] = "Please select a state";
                }
            }

            if ($key == "address1") {
                if (empty($value)) {
                    $this->errors[] = "Please select a address1";
                }
            }

            if ($key == "address2") {
                if (empty($value)) {
                    $this->errors[] = "Please select a address2";
                }
            }

            if ($key == "postal_code") {
                if (empty($value)) {
                    $this->errors[] = "Please enter a postal code";
                }
            }

            if ($key == "phone_number") {
                if (empty($value)) {
                    $this->errors[] = "Please enter a phone number";
                }
            }
        }
    }

    public function save_order($POST, $ROWS, $user_url, $sessionid)
    {

        $db = Database::newInstance();
        if (is_array($ROWS) && count($this->errors) == 0) {

            $countries = $this->load_model('Countries');
            $data = array();
            $data['user_url'] = $user_url;
            $data['delivery_address'] = $POST['address1'] . " " . $POST['address2'];
            $data['total'] = $POST['total'];
            $data['description'] = $POST['description'];
            //$country_obj = $countries->get_country($POST['country']) ;
            $data['country'] = $POST['country'];
            //$state_obj =  $countries->get_state($POST['state']);          
            $data['state'] =  $POST['state'];
            $data['postal_code'] = $POST['postal_code'];
            $data['tax'] = 0;
            $data['shipping'] = 0;
            $data['date'] = date('Y-m-d H:i:s');
            $data['sessionid'] = $sessionid;
            $data['phone_number'] = $POST['phone_number'];

            // save details
            $orderid = 0;
            $query = "select id from orders order by id desc limit 1";
            $result = $db->read($query);

            if (is_array($result)) {
                $orderid = $result[0]->id + 1;
            }

            $query = "INSERT INTO orders (description,user_url, delivery_address, total, country, state, postal_code, tax, shipping, date, sessionid, phone_number)
            VALUES (:description,:user_url, :delivery_address, :total, :country, :state, :postal_code, :tax, :shipping, :date, :sessionid, :phone_number)";

            $result = $db->write($query, $data);

            foreach ($ROWS as $row) {
                $data = array();
                $data['orderid'] = $orderid;
                $data['qty'] = $row->cart_qty;
                $data['description'] = $row->description;
                $data['amount'] = $row->price;
                $data['total'] = $row->price * $row->cart_qty;
                $data['productid'] = $row->id;
                $query = "INSERT INTO order_details (orderid, qty, description, amount, total, productid) VALUES (:orderid, :qty, :description, :amount, :total, :productid)";
                $result = $db->write($query, $data);
            }
        }
    }

    public function get_orders_by_user($user_url)
    {

        $orders = false;
        $db = Database::newInstance();
        $data = ['user_url' => $user_url];

        $query = "SELECT * FROM orders WHERE user_url = :user_url ORDER BY id DESC LIMIT 100";
        $orders = $db->read($query, $data);


        return $orders;
    }

    public function get_orders_count($user_url)
    {

        $db = Database::newInstance();
        $data = ['user_url' => $user_url];

        $query = "SELECT * FROM orders WHERE user_url = :user_url ";
        $result = $db->read($query, $data);

        $orders = is_array($result) ? count($result) : 0;
        return $orders;
    }

    public function get_all_orders()
    {
        // pagination formula
        $limit = 10;
        $offset = Page::get_offset($limit);

        $orders = false;
        $db = Database::newInstance();
        $query = "SELECT * FROM orders ORDER BY id DESC limit $limit offset $offset";
        $orders = $db->read($query);

        return $orders;
    }

    public function get_order_details($id)
    {

        $details = false;
        $data = ['id' => addslashes($id)];
        $db = Database::newInstance();

        $query = "SELECT * FROM order_details where orderid = :id ORDER BY id DESC";
        $details = $db->read($query, $data);

        return $details;
    }
}
