<?php 

    class Users extends Controller{

        public function index(){
            echo 'Index ';
        }

        public function adla($params){

            // var_dump($params);

        }

        public function uzvler(){
            
            echo 'uzvler';
            
            $this->view('homepage');
        }

    }