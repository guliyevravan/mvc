<?php

    //  AutoLoad
    require_once __DIR__ . '/autoload.php'; 
    require_once __DIR__ . '/core/config.php';
    
    
    Router::get('/', 'users@index');

    Router::get('/salam', function(){

        echo 'GET ILE GELEN';

    });