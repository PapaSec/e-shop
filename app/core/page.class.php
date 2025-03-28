<?php

class Page
{

    public static function generate($number)
    {
        $number = (int)$number;
        $query_string = str_replace("url=", "", $_SERVER['QUERY_STRING']);

        $current_link = ROOT . $query_string;
        if (!strstr($current_link, "pg=")) {
            $current_link .= "&pg=1";
        }

        return preg_replace("/pg=[^&?=]+/", "pg=" . $number, $current_link);
    }

    public static function links()
    {
        $links = (object)[];

        $links->prev = "";
        $links->next = "";
        $query_string = str_replace("url=", "", $_SERVER['QUERY_STRING']);

        $page_number = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
        $page_number = $page_number < 1 ? 1 : $page_number;

        $next_page = $page_number + 1;
        $prev_page = ($page_number > 1) ? $page_number - 1 : 1;

        $current_link = ROOT . $query_string;
        if (!strstr($current_link, "pg=")) {
            $current_link .= "&pg=1";
        }
        $links->prev = preg_replace("/pg=[^&?=]+/", "pg=" . $prev_page, $current_link);
        $links->next = preg_replace("/pg=[^&?=]+/", "pg=" . $next_page, $current_link);
        $links->current = $page_number;

        return $links;
    }
}
