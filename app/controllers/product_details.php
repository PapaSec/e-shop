<?php

class Product_details extends Controller
{
    public function index($slug)
    {
        $slug = esc($slug);

        $User = $this->load_model("User");
        $user_data = $User->check_login();

        if(is_object($user_data))
        {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();

        // Fetch product
        $ROW = $DB->read("select * from products where slug = :slug",['slug'=>$slug]);
        
        $data['page_title'] = "Product Details";
        $data['ROW'] = is_array($ROW) ? $ROW[0] : false;

        $this->view("product-details", $data);
    }
}
