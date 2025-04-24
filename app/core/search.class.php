<?php

class Search
{
    public function __construct()
    {
        // Constructor code here
    }

    public static function get_categories()
    {
        // This method retrieves categories from the database
        $DB = Database::newInstance();

        $query = "SELECT id, category FROM categories WHERE disabled = 0 ORDER BY views DESC";
        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                echo "<option id='$row->id'> $row->category </option>";
            }
        }
    }

    public static function get_brands()
    {
        // This method retrieves categories from the database
        $DB = Database::newInstance();

        $query = "SELECT id, brand FROM brands WHERE disabled = 0 ORDER BY views DESC";
        $data = $DB->read($query);

        $num = 0;
        if (is_array($data)) {
            foreach ($data as $row) {
                echo " <input id=\"$row->id\" value=\"$row->id\" type=\"checkbox\" class=\"form-checkbox-input\" name=\"brand-$num\">
                            <label for=\"$row->id\">$row->brand</label> . &nbsp";
                $num++;
            }
        }
    }

    public static function get_years()
    {
        // This method retrieves categories from the database
        $DB = Database::newInstance();

        $query = "SELECT date FROM products GROUP BY year(date)";
        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                echo "<option>" . date("Y", strtotime($row->date)) . "</option>";
            }
        }
    }
}
