<?php

class Search
{
    public function __construct()
    {
        // Constructor code here
    }

    public static function get_categories($name = '')
    {
        // This method retrieves categories from the database
        $DB = Database::newInstance();

        $query = "SELECT id, category FROM categories WHERE disabled = 0 ORDER BY views DESC";
        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                echo "<option value='$row->id' " . self::get_sticky('select', $name, $row->id) . "> $row->category </option>";
            }
        }
    }

    public static function get_brands($name)
    {
        // This method retrieves categories from the database
        $DB = Database::newInstance();

        $query = "SELECT id, brand FROM brands WHERE disabled = 0 ORDER BY views DESC";
        $data = $DB->read($query);

        $num = 0;
        if (is_array($data)) {
            foreach ($data as $row) {
                echo " <input " . self::get_sticky('checkbox', 'brand-' . $num, $row->id) . " id=\"$row->id\" value=\"$row->id\" type=\"checkbox\" class=\"form-checkbox-input\" name=\"brand-$num\">
                            <label for=\"$row->id\">$row->brand</label> . &nbsp";
                $num++;
            }
        }
    }

    public static function get_years($name)
    {
        // This method retrieves categories from the database
        $DB = Database::newInstance();

        $query = "SELECT date FROM products GROUP BY year(date)";
        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                $year = date("Y", strtotime($row->date));
                echo "<option " . self::get_sticky('select', $name, $year) . ">" . $year . "</option>";
            }
        }
    }

    public static function get_sticky($type, $name, $value = '', $default = null)
    {
        switch ($type) {
            case 'textbox':
                echo isset($_GET[$name]) ? htmlspecialchars($_GET[$name]) : "";
                break;

            case 'number':
                $def = 0;
                if ($default) {
                    $def = $default;
                }
                echo isset($_GET[$name]) ? htmlspecialchars($_GET[$name]) : $def;
                break;

            case 'select':
                return isset($_GET[$name]) && $value == $_GET[$name] ? "selected='true'" : "";

            case 'checkbox':
                return isset($_GET[$name]) && $value == $_GET[$name] ? "checked='true'" : "";
        }
    }

    public static function make_query($GET, $limit, $offset)
    {
        $params = array();

        // add description if available
        if (isset($GET['description']) && trim($GET['description']) != "") {
            $params['description'] = $GET['description'];
        }

        // add category if available
        if (isset($GET['category']) && trim($GET['category']) != "--Select Category--") {
            $params['category'] =  $GET['category'];
        }

        // add year if available
        if (isset($GET['year']) && trim($GET['year']) != "--Select Year--") {
            $params['year'] =  $GET['year'];
        }

        // add min-price if available
        if (isset($GET['min-price']) && trim($GET['max-price']) != "0" && trim($GET['min-price']) != "" && trim($GET['max-price']) != "") {
            $params['min-price'] =  (float)$GET['min-price'];
            $params['max-price'] =  (float)$GET['max-price'];
        }

        // add min-quantity if available
        if (isset($GET['min-qty']) && trim($GET['max-qty']) != "0" & trim($GET['min-qty']) != "" && trim($GET['max-qty']) != "") {
            $params['min-qty'] =  (int)$GET['min-qty'];
            $params['max-qty'] =  (int)$GET['max-qty'];
        }

        // add max-price if available
        if (isset($GET['max-price']) && trim($GET['max-price']) != "0") {
            $params['max-price'] =  $GET['max-price'];
        }

        $brands = array();
        // add brands if available
        foreach ($GET as $key => $value) {
            if (strstr($key, "brand-")) {
                $brands[] = $value;
            }
        }

        if (count($brands) > 0) {
            $params['brands'] = implode("','", $brands);
        }

        $query = "
             SELECT prod.*, cat.category as category_name, brands.brand as brand_name
             
             FROM products as prod join categories as cat on cat.id = prod.category 

             join brands on brands.id = prod.brand ";

        if (count($params) > 0) {
            $query .= " WHERE ";
        }

        if (isset($params['description'])) {
            $query .= " prod.description like '%$params[description]%' AND ";
        }

        if (isset($params['category'])) {
            $query .= " cat.id = '$params[category]' AND ";
        }

        if (isset($params['min-price'])) {
            $query .= " (prod.price BETWEEN '" . $params['min-price'] . "' AND '" . $params['max-price'] . "') AND ";
        }

        if (isset($params['min-qty'])) {
            $query .= " (prod.quantity BETWEEN '" . $params['min-qty'] . "' AND '" . $params['max-qty'] . "') AND ";
        }

        if (isset($params['brands'])) {
            $query .= " brands.id in ('" . $params['brands'] . "') AND ";
        }


        if (isset($params['year'])) {
            $query .= " YEAR(prod.date) = '$params[year]' AND ";
        }

        $query = trim($query);
        $query = trim($query, " AND ");
        $query .= "

             order by prod.id desc limit $limit offset $offset
            ";

        return $query;
    }
}
