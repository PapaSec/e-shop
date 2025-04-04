<?php

//*-- Database class to handle DB connection and queries --*//
class Database
{
    //*-- Holds the PDO connection instance --*//
    public static $con;

    public function __construct()
    {
        try {
            //*-- Establish the database connection --*//
            $string = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
            self::$con = new PDO($string, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            //*-- Stop execution on connection error --*//
            die($e->getMessage());
        }
    }

    //*-- Singleton method to get or create the connection instance --*//
    public static function getInstance()
    {
        if(self::$con) {
            return self::$con;
        }

       // return $instance = new self();
    }

    public static function newInstance()
    {
        return $instance = new self();
    }

    //*-- read from database --*//
    public function read($query, $data = array())
    {
        $stm = self::$con->prepare($query);
        $result = $stm->execute($data);

        if ($result) {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            if(is_array($data) && count($data) > 0)
            {
                return $data;
            }
        }
        return false;
    }

    //*-- write to database --*//
    public function write($query, $data = array())
    {
        $stm = self::$con->prepare($query);
        $result = $stm->execute($data);

        if($result) {

            return true;
        }

        return false;
    }
}
