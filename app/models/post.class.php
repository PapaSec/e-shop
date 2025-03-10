<?php

class Post
{
    public function create($DATA, $FILES, $image_class = null)
    {
        $_SESSION['error'] = "";
        $_SESSION['post_data'] = $DATA;

        $DB = Database::newInstance();
        $arr['title']       = ucwords($DATA['title']);
        $arr['post']        = $DATA['post'];
        $arr['date']        = date("Y-m-d H:i:s");
        $arr['user_url']    = $_SESSION['user_url'];
        $arr['url_address'] = str_to_url($DATA['title']);

        // Validation
        if (!preg_match("/^[a-zA-Z 0-9._\-]+$/", trim($arr['title']))) {
            $_SESSION['error'] .= "Invalid title for this post<br>";
        }

        if (empty($arr['post'])) {
            $_SESSION['error'] .= "Please enter some valid content<br>";
        }

        // URL uniqueness check
        $url_address_arr['url_address'] = $arr['url_address'];
        $query = "SELECT url_address FROM blogs WHERE url_address = :url_address LIMIT 1";
        $check = $DB->read($query, $url_address_arr);

        if ($check) {
            $arr['url_address'] .= "-" . rand(0, 99999); // Fixed rand() parameters
        }


        // Image handling
        $arr['image'] = "";
        $allowed = ["image/jpeg"];
        $size = 10 * 1024 * 1024; // 10MB
        $folder = "uploads/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // Check for files
        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr[$key] = $destination;
                    $image_class->resize_image($destination, $destination, 1500, 1500);
                } else {
                    $_SESSION['error'] .= $key . "Size is bigger than required size<br>";
                }
            }
        }

        if (empty($arr['image'])) {
            $_SESSION['error'] .= "An image is required<br>";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "insert into blogs (title,post,date,user_url,image,url_address) values (:title,:post,:date,:user_url,:image,:url_address)";
            $check = $DB->write($query, $arr);

            if ($check) {
                return true;
            }
        }
        return false;
    }

    public function delete($url_address)
    {

        $arr['url_address'] = $url_address;

        $DB = Database::newInstance();
        $query = "delete from blogs where url_address = :url_address limit 1";
        $DB->write($query);
    }

    public function get_one($url_address)
    {
        $arr['url_address'] = $url_address;

        $DB = Database::newInstance();
        $data =  $DB->read("select * from blogs where url_address = :url_address limit 1", $arr);
        return $data[0];
    }

    public function get_all()
    {
        $DB = Database::newInstance();
        return $DB->read("select * from blogs order by id desc");
    }
}
