<?php

class Payment extends Controller
{
    public function index()
    {
        $data = file_get_contents("php://input");

        $filename = time() . "_txt";

        file_put_contents($filename, $data);
    }
}
