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
                        $ROWS[$key]->cart_qty =  $item['qty'];
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
        $data['orders'][] = $_SESSION['POST_DATA'];
        $data['page_title'] = "Checkout - Summary";


        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['POST_DATA'])) {

            $sessionid = session_id();
            $user_url = "";
            if (isset($_SESSION['user_url'])) {
                $user_url = $_SESSION['user_url'];
            }

            $order = $this->load_model('Order');
            $order->save_order($_SESSION['POST_DATA'], $ROWS, $user_url, $sessionid);
            $data['errors'] = $order->errors;

            unset($_SESSION['POST_DATA']);
            unset($_SESSION['CART']);

            header("Location:" . ROOT . "checkout/thank_you");
            die;
        }
        $this->view("checkout.summary", $data);
    }

    public function thank_you()
    {

        $data['page_title'] = "Thank You";
        $this->view("checkout.thank_you", $data);
    }
}
