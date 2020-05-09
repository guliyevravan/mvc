<?php 

    class Database { 

        protected $db;

        private $db_host = DB_HOST ?? null;
        private $db_name = DB_NAME ?? null;
        private $db_user = DB_USER ?? null;
        private $db_pass = DB_PASS ?? null;     

        public function __construct(){

            try
            {
                //  Eger butun melumatlar varsa
                if(!$this->db_host || !$this->db_name || !$this->db_user)
                {
                    throw new Exception("Database'ə qoşulmaq üçün DB məlumatlarını qeyd edin");
                }

                $this->db = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
            
                $this->db->query("SET NAMES UTF8");
                $this->db->query("SET CHARACTER SET utf8");
                $this->db->query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");  
                $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                echo 'Database bağlantısında xəta baş verdi';
                die();
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                die();
            }

        }

        public function __destruct(){
            
            //  Close Database
            $this->db = null;

        }
    }