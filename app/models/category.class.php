<?php

class Category
{
    public function create($DATA)
    {
        $DB = Database::newInstance();
        $arr['category'] = ucwords($DATA->category);
        $arr['parent'] = ucwords($DATA->parent);

        if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['category']))) {
            $_SESSION['error'] = "Invalid category name";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "insert into categories (category, parent) values (:category, :parent)";
            $check = $DB->write($query, $arr);

            if ($check) {
                return true;
            }
        }
        return false;
    }

    public function edit($data)
    {
        $DB = Database::newInstance();
        $arr['id'] = $data->id;
        $arr['category'] = $data->category;
        $arr['parent'] = $data->parent;
        $query = "update categories set category = :category, parent = :parent where id = :id limit 1";
        $DB->write($query, $arr);
    }

    public function delete($id)
    {

        $DB = Database::newInstance();
        $id = (int)$id;
        $query = "delete from categories where id = '$id' limit 1";
        $DB->write($query);
    }


    public function get_all()
    {
        $DB = Database::newInstance();
        return $DB->read("select * from categories order by views desc");
    }

    public function get_one($id)
    {
        $id = (int)$id;

        $DB = Database::newInstance();
        $data =  $DB->read("select * from categories where id = '$id' limit 1");
        return $data[0];
    }

    public function get_one_by_name($name)
    {
        $name = addslashes($name);

        $DB = Database::newInstance();
        $data =  $DB->read("select * from categories where category like :name limit 1", ["name" => $name]);

        if (is_array($data)) {
            $DB->write("update categories set views = views + 1 where id = :id limit 1", ["id" => $data[0]->id]);
        }
        return $data[0];
    }
    public function make_table($cats)
    {

        $result = "";
        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                $bgColor = $cat_row->disabled ? "#fca395" : "#dcfce7";
                $textColor = $cat_row->disabled ? "#ffffff" : "#16a34a";  // White for disabled, green for enabled
                $cat_row->disabled = $cat_row->disabled ? "Disabled" : "Enabled";

                $args = $cat_row->id . ",'" . $cat_row->disabled . "'";
                $edit_args = $cat_row->id . ",'" . addslashes($cat_row->category) . "'," . $cat_row->parent;
                $parent = "";

                foreach ($cats as $cat_row2) {
                    if ($cat_row->parent == $cat_row2->id) {
                        $parent = $cat_row2->category;
                    }
                }

                $result .= "<tr>";
                $result .= '
                    <td>' . $cat_row->category . '</td>
                    <td>' . $parent . '</td>
                    <td><span onclick="disable_row(' . $args . ')" class="status-badge status-active" style="background-color: ' . $bgColor . '; color: ' . $textColor . ';">' . $cat_row->disabled . '</span></td>
                    
                    <td class="action-buttons">
                        <button onclick="show_edit_category(' . $edit_args . ')" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i></button>
                        <button onclick="delete_row(' . $cat_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                    </td>';
                $result .= "</tr>";
            }
        }

        return $result;
    }
}
