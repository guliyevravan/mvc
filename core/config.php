<?php 

    //  ENVIRONMENT
    const ENVIRONMENT = 'development'; // production

    const DB_HOST = 'localhost';
    const DB_NAME = 'safe_express';
    const DB_USER = 'root';
    const DB_PASS = '';

    switch(ENVIRONMENT)
    {
        case 'development' : 
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;
        case 'production':
            ini_set('display_errors', 0);
            if (version_compare(PHP_VERSION, '5.3', '>='))
            {
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
            }
            else
            {
                error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
            }
        break;

        default : 
		    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		    echo 'Zəhmət olmasa enviroment seçin';
		exit(1); // EXIT_ERROR
    }
    
	date_default_timezone_set ('Asia/Baku');