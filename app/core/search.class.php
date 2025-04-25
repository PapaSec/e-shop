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

    public static function get_sticky($type, $name, $value = '')
    {
        switch ($type) {
            case 'textbox':
                echo isset($_GET[$name]) ? htmlspecialchars($_GET[$name]) : "";
                break;

            case 'number':
                echo isset($_GET[$name]) ? htmlspecialchars($_GET[$name]) : "0";
                break;

            case 'select':
                return isset($_GET[$name]) && $value == $_GET[$name] ? "selected='true'" : "";

            case 'checkbox':
                return isset($_GET[$name]) && $value == $_GET[$name] ? "checked='true'" : "";
        }
    }
}
