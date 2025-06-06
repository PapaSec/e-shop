<?php

class Home extends Controller
{
    public function index()
    {
        $limit = 6;
        $offset = Page::get_offset($limit);

        $search = false;
        if (isset($_GET['search'])) {
            $search = true;
        }

        // check if its a serach request
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
        $data['page_title'] = "Home";

        // read main posts
        if ($search) {
            if (isset($_GET['find'])) {
                $arr['description'] = "%" . $find . "%";
                $ROWS = $DB->read("select * from products where description like :description limit $limit offset $offset", $arr);
            } else {
                // Advanced search
                // GENERATE A SEARCH QUERY
                $query = Search::make_query($_GET, $limit, $offset);
                $ROWS = $DB->read($query);
            }
        } else {
            $ROWS = $DB->read("select * from products limit $limit offset $offset ");
        }

        if ($ROWS) {
            foreach ($ROWS as $key => $row) {
                $ROWS[$key]->image = $image_class->get_thumb_post($ROWS[$key]->image);
            }
        }

        $data['ROWS'] = $ROWS;


        // carousel posts pages
        $carousel_pages_count = 3;
        for ($i = 0; $i < $carousel_pages_count; $i++) {
            $Slider_ROWS[$i] = $DB->read("select * from products where rand() limit 3");
            if ($Slider_ROWS[$i]) {
                foreach ($Slider_ROWS[$i] as $key => $row) {
                    $Slider_ROWS[$i][$key]->image = $image_class->get_thumb_post($Slider_ROWS[$i][$key]->image);
                }
            }
            $data['Slider_ROWS'][] = $Slider_ROWS[$i];
        }

        // get all categories
        $category = $this->load_model("category");
        $data['categories'] = $category->get_all();

        // get products for lower segment
        $data['segment_data'] = $this->get_segment_data($DB, $data['categories'], $image_class);

        // get all slider content
        $Slider = $this->load_model("slider");
        $data['slider'] = $Slider->get_all();

        if ($data['slider']) {
            foreach ($data['slider'] as $key => $row) {
                $data['slider'][$key]->image = $image_class->get_thumb_post($row->image, 484, 441);
            }
        }

        $data['show_search'] = true;
        $this->view("index", $data);
    }

    private function get_segment_data($DB, $categories, $image_class)
    {
        $results = [];
        $mycats = [];
        $num = 0;
        foreach ($categories as $cat) {
            $arr['id'] = $cat->id;
            $ROWS = $DB->read("select * from products where category = :id order by rand() limit 5", $arr);
            if (is_array($ROWS)) {
                // crop images 
                foreach ($ROWS as $key => $row) {
                    $ROWS[$key]->image = $image_class->get_thumb_post($ROWS[$key]->image);
                }


                $results[$cat->category] = $ROWS;

                $num++;
                if ($num > 5) {
                    break;
                }
            }
        }
        return $results;
    }
}
