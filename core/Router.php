<?php 
    
    class Router {

        //  Parse URL
        public static function parse_url()
        {
            //  URL emeliyyatlari
            $request_uri    = $_SERVER['REQUEST_URI'];
            $script_name    = $_SERVER['SCRIPT_NAME'];
            $dirname        = dirname($_SERVER['SCRIPT_NAME']);
            
            if($dirname != '/' && $dirname != '\\')
            {
                $request_uri    = substr($request_uri, strlen($dirname));
            }
            
            //  Url SON
            return $request_uri;
        }

        /**  As of PHP 5.3.0  */
        public static function __callStatic($name, $arguments)
        {
            //  Metodu tapaq
            $method = strtoupper($name);

            //  Metodu arqument kimi gonderek
            $arguments[] = $method;
            
            call_user_func_array([__CLASS__, 'run'], $arguments);
        }

        //  Get
        public static function run($url, $callback, $method = 'GET')
        {
            //  Method yoxdursa
            if($_SERVER['REQUEST_METHOD'] != $method)
            {
                return;
            }

            //  URL'i tapaq
            $request_uri = self::parse_url();
            
            //  URL'i bolek
            $explode_url_for_params = explode('/', $url);

            //  URL i / isaresine gore ayiraq
            foreach($explode_url_for_params as $param)
            { 
                $has_parameter = preg_match("@^{([0-9a-z]+)}$@", $param, $params);
                
                if(!$has_parameter)
                continue;

                //  Url'de deyisek
                $url = str_replace($param, "([0-9a-zA-Z_]+)", $url);
            }

            //  Query'ni silek
            $request_uri = explode('?', $request_uri);
            $request_uri = $request_uri[0];
            
            //  Diger hersey
            if($url == '*')
            {
                $url = $request_uri;
            }
            
            //  Bele Router varsa
            if(preg_match("@^" .$url. "$@", $request_uri, $parameters))
            {
                
                //  Ilk parametri silek
                unset($parameters[0]);

                //  Funksiya varsa
                if(is_callable($callback))
                {
                    call_user_func_array($callback, $parameters);
                    die();
                    return;
                }

                //  Controller
                $controller_bol = explode("@", $callback);
                
                //  Eger yalniz contoroller adi yazilibsa
                if(count($controller_bol) == 2)
                {
                    $controller = $controller_bol[0];
                    $method     = $controller_bol[1];
                }
                else
                {
                    $controller = $callback;
                    $method     = 'index';
                }

                $controller_file = __DIR__ . '/../controllers/' . $controller . '.php';
                
                //  Eger fayl varsa
                if(file_exists($controller_file))
                {  
                    //  Cagiraq
                    require_once($controller_file);
                    
                    //  Folder'leri silek
                    $controller_bol = explode('/', $controller);
                    $controller = $controller_bol[count($controller_bol) - 1];

                    //  Isledek
                    call_user_func_array([new $controller, $method], $parameters);

                    //  Dayandiraq
                    die();
                }
                else
                {
                    return;
                }
            }
            else
            {
                return;
            }

        }

    }