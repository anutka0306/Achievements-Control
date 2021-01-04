<?php


class Model
{
    public $db;
    public $UID;

    function __construct()
    {
        $this->db = new DB();
        $this->UID = $_SESSION['login'];

    }

    public function get_data(){

    }
}