<?php

class Add_to_cart extends Controller
{

    private $redirect_to = "";
    public function index($id = '')
    {

        $id = esc($id);
        $DB = Database::newInstance();

        $ROWS = $DB->read("select * from products where id = :id limit 1", ["id" => $id]);

        if ($ROWS) {
            $ROW = $ROWS[0];
            if (isset($_SESSION['CART'])) {

                $ids = array_column($_SESSION['CART'], "id");
                if (in_array($ROW->id, $ids)) {

                    $key = array_search($ROW->id, $ids);
                    $_SESSION['CART'][$key]['qty']++;
                } else {
                    $arr = array();
                    $arr['id'] = $ROW->id;
                    $arr['qty'] = 1;

                    $_SESSION['CART'][]  = $arr;
                }
            } else {

                $arr = array();
                $arr['id'] = $ROW->id;
                $arr['qty'] = 1;

                $_SESSION['CART'][]  = $arr;
            }
        }
        header("Location: ". ROOT . "cart");
    }

    //Subtract
    public function subtract_quantity($id = '')
    {
        $this->set_redirect();

        $id = esc($id);
        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {

                if ($item['id'] == $id) {

                    $_SESSION['CART'][$key]['qty'] -= 1;
                    break;
                }
            }
        }
        $this->redirect();
    }

    //Add 
    public function add_quantity($id = '')
    {
        $this->set_redirect();

        $id = esc($id);
        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {

                if ($item['id'] == $id) {

                    $_SESSION['CART'][$key]['qty']++;
                    break;
                }
            }
        }
        $this->redirect();
    }

    //Delete
    public function remove($id = '')
    {
        $this->set_redirect();

        $id = esc($id);
        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {

                if ($item['id'] == $id) {

                    unset($_SESSION['CART'][$key]);
                    $_SESSION['CART'] = array_values($_SESSION['CART']);
                    break;
                }
            }
        }
        $this->redirect();
    }

    private function redirect()
    {
        header("Location: ". $this->redirect_to);
        die;
    }

    private function set_redirect()
    {
        if(isset($_SERVER['HTTP_REFERER']) &&$_SERVER['HTTP_REFERER'] != "")
        {
            $this->redirect_to = $_SERVER['HTTP_REFERER'];
        }else{
            $this->redirect_to = ROOT . "shop";
        }
    }
}
