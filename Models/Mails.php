<?php

    class Mail
    {
        private $table ="mails";
        private $connection = null;

        // Les propriétés de l'objet "mail"
        public $id;
        public $lastname;
        public $firstname;
        public $phone;
        public $email;
        public $message;


        public function __construct($db)
        {
            if ($this->connection == null) {
                $this->connection = $db;
            }
        }
        
        // Récupérer la table "mails" :
        public function getMails()
        {
            $sql = "SELECT * FROM $this->table";
            $req = $this->connection->query($sql);
            return $req;
        }

        // Ajouter un mail :
        public function addMail()
        {
            $sql = "INSERT INTO $this->table(lastname, firstname, phone, email, message) VALUES (:lastname, :firstname, :phone, :email, :message)";
            $req = $this->connection->prepare($sql);
            $re= $req->execute([
                ":lastname" => $this->lastname,
                ":firstname" => $this->firstname,
                ":phone" => $this->phone,
                ":email" => $this->email,
                ":message" => $this->message
            ]);
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

        // Supprimer un mail :
        public function deleteMail()
        {
            $sql="DELETE FROM $this->table WHERE id=:id";
            $req= $this->connection->prepare($sql);
            $re = $req->execute(array(":id" => $this->id));
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

    }









