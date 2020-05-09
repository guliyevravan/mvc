<?php 

    //  BASE CONTROLLER
    class Controller {

        public static function view($name, $data = [])
        {

            //  Deyiskenler
            extract($data);

            //  View cagiraq
            require_once(__DIR__ . '/../views/' . strtolower($name) . '.php');

        }

        public static function model($name)
        {
            require_once(__DIR__ . '/../models/' . $name . '.php');
            return new $name();
        }
    }