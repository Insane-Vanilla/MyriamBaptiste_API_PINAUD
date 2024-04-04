<?php

    class Database
    {
        private $host = "mysql-pinaud.alwaysdata.net";
        private $dbname = "pinaud_myriambaptiste";
        private $username = "pinaud";
        private $password = "Studidev38650";
        private $port = "3306";

        //Connexion à la base de données :
        public function getConnection()
        {
            $conn = null;
            try {
                $conn = new PDO(
                    "mysql:host=$this->host; dbname=$this->dbname; port=$this->port; charset=utf8", $this->username, $this->password,
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                        ]
                    );
            } catch(\PDOException $e){
                echo "Erreur de connexion :" . $e->getMessage();
            }
            return $conn;
        }
    }

