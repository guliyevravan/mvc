<?php 

    class Users extends Model {

        public function getAll(){
            
            $users = $this->db->query('select * from users limit 50');

            return $users->fetchAll(PDO::FETCH_ASSOC);

        }

    }