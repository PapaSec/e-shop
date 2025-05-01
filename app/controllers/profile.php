<?php

class Profile extends Controller
{
    public function index($url_address = null)
    {

        $User = $this->load_model("User");
        $Order = $this->load_model("Order");
        $user_data = $User->check_login(true);

        if ($url_address) {
            $profile_data = $User->get_user($url_address);
        } else {
            $profile_data = $user_data;
        }

        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }
        var_dump($profile_data);
        if (is_array($profile_data)) {
            $orders = $Order->get_orders_by_user($profile_data->url_address);
        } else {
            $orders = false;
        }

        if (is_array($orders)) {
            foreach ($orders as $key => $row) {
                $details = $Order->get_order_details($row->id);
                $totals = array_column($details, "total");
                $grand_total = array_sum($totals);

                $orders[$key]->details = $details;
                $orders[$key]->grand_total = $grand_total;
            }
        }

        $data['profile_data'] = $profile_data;
        $data['page_title'] = "Profile";
        $data['orders'] = $orders;

        $this->view("profile", $data);
    }
}
