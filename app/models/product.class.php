<?php

class Product
{
    public function create($DATA, $FILES, $image_class = null)
    {
        $_SESSION['error'] = "";

        $DB = Database::newInstance();
        $arr['description'] = ucwords($DATA->description);
        $arr['quantity']    =  $DATA->quantity;
        $arr['category']    =  $DATA->category;
        $arr['brand']       =  $DATA->brand;
        $arr['price']       =  $DATA->price;
        $arr['date']        = date("Y-m-d H:i:s");
        $arr['user_url']    = $_SESSION['user_url'];
        $arr['slug']        = str_to_url($DATA->description);

        if (!preg_match("/^[a-zA-Z 0-9._\-]+$/", trim($arr['description']))) {
            $_SESSION['error'] .= "Invalid description for this product<br>";
        }

        if (!is_numeric($arr['quantity'])) {
            $_SESSION['error'] .= "Please enter a valid quantity<br>";
        }

        if (!is_numeric($arr['category'])) {
            $_SESSION['error'] .= "Please enter a valid category<br>";
        }

        if (!is_numeric($arr['brand'])) {
            $_SESSION['error'] .= "Please enter a valid brand<br>";
        }

        if (!is_numeric($arr['price'])) {
            $_SESSION['error'] .= "Please enter a valid price<br>";
        }

        // Checking slug is unique
        $slug_arr['slug'] = $arr['slug'];
        $query = "select slug from products where slug = :slug limit 1";
        $check = $DB->read($query, $slug_arr);

        if ($check) {
            $arr['slug'] .= "-" . rand(0.99999);
        }

        $arr['image']  = "";
        $arr['image2'] = "";
        $arr['image3'] = "";
        $arr['image4'] = "";

        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";
        $size = 10;
        $size = ($size * 1024 * 1024);
        $folder = "uploads/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // Check for files
        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $extension = ($img_row['type'] == "image/png") ? ".png" : ".jpg";
                    $destination = $folder . $image_class->generate_filename(60) . $extension;

                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr[$key] = $destination;
                    $image_class->resize_image($destination, $destination, 1500, 1500);
                } else {
                    $_SESSION['error'] .= $key . "Size is bigger than required size<br>";
                }
            }
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "insert into products (description,quantity,category,brand,price,date,user_url,image,image2,image3,image4,slug) values (:description,:quantity,:category,:brand,:price,:date,:user_url,:image,:image2,:image3,:image4,:slug)";
            $check = $DB->write($query, $arr);

            if ($check) {
                return true;
            }
        }
        return false;
    }

    public function edit($data, $FILES, $image_class = null)
    {

        $arr['id'] = $data->id;
        $arr['description'] = $data->description;
        $arr['quantity'] = $data->quantity;
        $arr['category'] = $data->category;
        $arr['brand'] = $data->brand;
        $arr['price'] = $data->price;
        $image_string = "";

        if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['description']))) {
            $_SESSION['error'] .= "Invalid description for this product<br>";
        }

        if (!is_numeric($arr['quantity'])) {
            $_SESSION['error'] .= "Please enter a valid quantity<br>";
        }

        if (!is_numeric($arr['category'])) {
            $_SESSION['error'] .= "Please enter a valid category<br>";
        }

        if (!is_numeric($arr['brand'])) {
            $_SESSION['error'] .= "Please enter a valid brand<br>";
        }

        if (!is_numeric($arr['price'])) {
            $_SESSION['error'] .= "Please enter a valid price<br>";
        }

        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";
        $size = 10;
        $size = ($size * 1024 * 1024);
        $folder = "uploads/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // Check for files
        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $extension = ($img_row['type'] == "image/png") ? ".png" : ".jpg";
                    $destination = $folder . $image_class->generate_filename(60) . $extension;

                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr[$key] = $destination;
                    $image_class->resize_image($destination, $destination, 1500, 1500);

                    $image_string .= "," . $key . " = :" . $key;
                } else {
                    $_SESSION['error'] .= $key . "Size is bigger than required size<br>";
                }
            }
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $DB = Database::newInstance();
            $query = "update products set description = :description, quantity = :quantity, category = :category, brand = :brand, price = :price $image_string where id = :id limit 1";
            $DB->write($query, $arr);
        }
    }

    public function delete($id)
    {

        $DB = Database::newInstance();
        $id = (int)$id;
        $query = "delete from products where id = '$id' limit 1";
        $DB->write($query);
    }

    public function get_all()
    {
        $DB = Database::newInstance();
        return $DB->read("select * from products order by category desc");
    }

    public function get_one($id)
    {
        $id = (int)$id;
        $DB = Database::newInstance();
        $data = $DB->read("SELECT * FROM categories WHERE id = '$id' LIMIT 1");
        return $data[0];
    }

    public function make_table($cats, $model = null)
    {

        $result = "";
        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                $edit_args = $cat_row->id . ",'" . $cat_row->description . "'";

                $info = array();
                $info['id'] = $cat_row->id;
                $info['description'] = $cat_row->description;
                $info['quantity'] = $cat_row->quantity;
                $info['price'] = $cat_row->price;
                $info['category'] = $cat_row->category;
                $info['brand_name'] = $cat_row->brand_name;
                $info['image'] = $cat_row->image;
                $info['image2'] = $cat_row->image2;
                $info['image3'] = $cat_row->image3;
                $info['image4'] = $cat_row->image4;

                $info = str_replace('"', "'", json_encode($info));

                //$one_cat = $this->get_one($cat_row->category);
                $result .= "<tr>";

                $result .= '
                    <td>' . $cat_row->id . '</td>
                    <td>' . $cat_row->description . '</td>
                    <td>' . $cat_row->quantity . '</td>
                    <td>' . $cat_row->category_name . '</td>
                    <td>' . $cat_row->brand_name . '</td>
                    <td>' . $cat_row->price . '</td>
                    <td>' . date("jS M y", strtotime($cat_row->date)) . '</td>
                    <td><img src="' . ROOT . $cat_row->image . '" style="width:50px; height:50px;" /></td>

                    <td class="action-buttons">
                        <button info="' . $info . '" onclick="show_edit_product(' . $edit_args . ',event)" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i></button>
                        <button onclick="delete_row(' . $cat_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                    </td>';
                $result .= "</tr>";
            }
        }

        return $result;
    }
}
