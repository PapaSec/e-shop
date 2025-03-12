<?php

class Blog extends Controller
{
    public function index()
    {

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
            $arr['title'] = "%" . $find . "%";
            $ROWS = $DB->read("select * from blogs where title like :title ", $arr);
        } else {
            $ROWS = $DB->read("select * from blogs order by id desc");
        }

        $data['page_title'] = "Blog";

        if ($ROWS) {
            foreach ($ROWS as $key => $row) {
                $ROWS[$key]->image = $image_class->get_thumb_blog_post($ROWS[$key]->image);
            }
        }

        // get all categories
        $category = $this->load_model("category");
        $data['categories'] = $category->get_all();

        $data['ROWS'] = $ROWS;
        $data['show_search'] = true;
        $this->view("blog", $data);
    }
}
