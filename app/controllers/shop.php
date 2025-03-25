<?php

class Shop extends Controller
{
    public function index()
    {
        //pagination formula
        $limit = 3;
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page_number - 1) * $limit;

        // check if its a serach request
        $search = false;
        if (isset($_GET['find'])) {
            $find = addslashes($_GET['find']);
            $search = true;
        }

        $User = $this->load_model("User");
        $image_class = $this->load_model("Image");
        $user_data = $User->check_login();

        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();

        if ($search) {
            $arr['description'] = "%" . $find . "%";
            $ROWS = $DB->read("select * from products where description like :description limit $limit offset $offset", $arr);
        } else {
            $ROWS = $DB->read("select * from products limit $limit offset $offset");
        }


        $data['page_title'] = "Shop";

        if ($ROWS) {
            foreach ($ROWS as $key => $row) {
                $ROWS[$key]->image = $image_class->get_thumb_post($ROWS[$key]->image);
            }
        }

        // get all categories
        $category = $this->load_model("category");
        $data['categories'] = $category->get_all();

        $data['ROWS'] = $ROWS;
        $data['show_search'] = true;
        $this->view("shop", $data);
    }

    public function category($cat_find = '')
    {
        //pagination formula
        $limit = 3;
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page_number - 1) * $limit;

        $User = $this->load_model("User");
        $category = $this->load_model("category");
        $image_class = $this->load_model("Image");
        $user_data = $User->check_login();

        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();

        $cat_id = null;
        $check = $category->get_one_by_name($cat_find);
        if (is_object($check)) {
            $cat_id = $check->id;
        }

        $ROWS = $DB->read("select * from products where category = :cat_id limit $limit offset $offset", ['cat_id' => $cat_id]);

        $data['page_title'] = "Shop";

        if ($ROWS) {
            foreach ($ROWS as $key => $row) {
                $ROWS[$key]->image = $image_class->get_thumb_post($ROWS[$key]->image);
            }
        }

        // get all categories
        $data['categories'] = $category->get_all();

        $data['ROWS'] = $ROWS;
        $data['show_search'] = true;

        $this->view("shop", $data);
    }
}
