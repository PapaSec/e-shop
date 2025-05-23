<?php

class User
{
    private $error = "";

    //* -- Signup class -- *//
    public function signup($POST)
    {
        $data = array();
        $db = Database::newInstance();

        $data['name']  = trim($POST['name']);
        $data['email']  = trim($POST['email']);
        $data['password']  = trim($POST['password']);
        $password2  = trim($POST['password2']);

        if (empty($data['email']) || !preg_match("/^[a-zA-Z_-]+@[a-zA-Z]+\.[a-zA-Z]+$/", $data['email'])) {
            $this->error .= "Invalid email address<br>";
        }

        if (empty($data['name']) || !preg_match("/^[a-zA-Z]+$/", $data['name'])) {
            $this->error .= "Please enter valid name <br>";
        }

        if ($data['password'] !== $password2) {
            $this->error .= "Password does not match <br>";
        }

        if (strlen($data['password']) < 6) {
            $this->error .= "Password must be at least 6 characters <br>";
        }

        // Check if email already exists
        $sql = "select * from users where email = :email limit 1";
        $arr['email'] = $data['email'];
        $check = $db->read($sql, $arr);
        if (is_array($check)) {
            $this->error .= "Email already exists <br>";
        }

        $data['url_address'] = $this->get_random_string_max(60);
        // Check if url_address already exists
        $arr = array();
        $sql = "select * from users where url_address = :url_address limit 1";
        $arr['url_address'] = $data['url_address'];
        $check = $db->read($sql, $arr);
        if (is_array($check)) {
            $data['url_address'] = $this->get_random_string_max(60);
        }

        if ($this->error == "") {
            //save to db
            $data['rank'] = "customer";
            $data['date'] = date("Y-m-d H:i:s");
            $data['password'] = hash('sha1', $data['password']);
            $query = "insert into users (name,email,password,rank,url_address,date) values(:name,:email,:password,:rank,:url_address,:date)";

            $result = $db->write($query, $data);

            if ($result) {
                header("Location: " . ROOT . "login");
                die;
            }
        }

        $_SESSION['error'] = $this->error;
    }

    //* -- Login class -- *//
    public function login($POST)
    {
        $data = array();
        $db = Database::newInstance();

        $data['email']  = trim($POST['email']);
        $data['password']  = trim($POST['password']);

        if (empty($data['email']) || !preg_match("/^[a-zA-Z_-]+@[a-zA-Z]+\.[a-zA-Z]+$/", $data['email'])) {
            $this->error .= "Invalid email address<br>";
        }

        if (strlen($data['password']) < 6) {
            $this->error .= "Password must be at least 6 characters <br>";
        }

        if ($this->error == "") {

            //cornfirm email and password
            $data['password'] = hash('sha1', $data['password']);

            //check if email and password already exists
            $sql = "select * from users where email = :email && password = :password limit 1";
            $result = $db->read($sql, $data);
            if (is_array($result)) {

                $_SESSION['user_url'] = $result[0]->url_address;

                if (isset($_SESSION['intended_url'])) {
                    $url = $_SESSION['intended_url'];
                    unset($_SESSION['intended_url']);
                    header("Location: " . $url);
                } else {
                    header("Location: " . ROOT . "home");
                }
                die;
            }

            $this->error .= "Incorrect email or password<br>";
        }

        $_SESSION['error'] = $this->error;
    }

    public function get_user($url)
    {
        $db = Database::newInstance();
        $arr = [];
        $arr['url_address'] = addslashes($url);
        $query = "select * from users where url_address = :url_address limit 1";
        $result = $db->read($query, $arr);

        if (is_array($result)) {
            return $result[0];
        }
        return false;
    }

    public function get_customers()
    {
        $db = Database::newInstance();
        $arr = [];
        $arr['rank'] = "customer";
        $query = "select * from users where rank = :rank";
        $result = $db->read($query, $arr);

        if (is_array($result)) {
            return $result;
        }
        return false;
    }

    public function get_admins()
    {
        $db = Database::newInstance();
        $arr = [];
        $arr['rank'] = "admin";
        $query = "select * from users where rank = :rank";
        $result = $db->read($query, $arr);

        if (is_array($result)) {
            return $result;
        }
        return false;
    }

    private function get_random_string_max($length)
    {

        $array = array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z'
        );

        $text = "";

        $length = rand(4, $length);

        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, 61);

            $text .= $array[$random];
        }

        return $text;
    }

    public function check_login($redirect = false, $allowed = array())
    {
        $db = Database::newInstance();

        // Check if user_url is set in session
        if (!isset($_SESSION['user_url'])) {
            if ($redirect) {
                $_SESSION['intended_url'] = FULL_URL;
                header("Location: " . ROOT . "login");
                die;
            }
            return false;
        }

        // If allowed ranks are specified
        if (count($allowed) > 0) {
            $arr = [];
            $arr['url'] = $_SESSION['user_url'];
            $query = "select * from users where url_address = :url limit 1";
            $result = $db->read($query, $arr);

            if (is_array($result)) {
                $result = $result[0];
                if (in_array($result->rank, $allowed)) {
                    return $result;
                }
            }
            $_SESSION['intended_url'] = FULL_URL;
            header("Location: " . ROOT . "login");
            die;
        } else {
            // Already checked isset($_SESSION['user_url']) above, so proceed
            $arr = [];
            $arr['url'] = $_SESSION['user_url'];
            $query = "select * from users where url_address = :url limit 1";
            $result = $db->read($query, $arr);

            if (is_array($result)) {
                return $result[0];
            }

            if ($redirect) {
                echo "here1";
                $_SESSION['intended_url'] = FULL_URL;
                header("Location: " . ROOT . "login");
                die;
            }
        }

        return false;
    }

    public function logout()
    {
        if (isset($_SESSION['user_url'])) {
            unset($_SESSION['user_url']);
        }
        header("Location: " . ROOT . "home");
        die;
    }
}
