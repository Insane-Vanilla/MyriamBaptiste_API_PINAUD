<?php

    class Service
    {
        private $table ="services";
        private $connection = null;

        // Les propriétés de l'objet "services"
        public $id;
        public $category;
        public $title;
        public $subtitle;
        public $description;
        public $price;

        public function __construct($db)
        {
            if ($this->connection == null) {
                $this->connection = $db;
            }
        }
        
        // Récupérer la table "services" :
        public function getServices()
        {
            $sql = "SELECT * FROM $this->table";
            $req = $this->connection->query($sql);
            return $req;
        }

        // Ajouter un service :
        public function addService()
        {
            $sql = "INSERT INTO $this->table(category, title, subtitle, description, price) 
            VALUES (:category, :title, :subtitle, :description, :price)";
            $req = $this->connection->prepare($sql);
            $re= $req->execute([
                ":category" => $this->category,
                ":title" => $this->title,
                ":subtitle" => $this->subtitle,
                ":description" => $this->description,
                ":price" => $this->price,
            ]);
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

        // Modifier un service :
        public function updateService()
        {
            $sql="UPDATE $this->table SET category=:category, title=:title, subtitle=:subtitle, 
            description=:description, price=:price WHERE id=:id";
            $req = $this->connection->prepare($sql);
            $re= $req->execute([
                ":category" => $this->category,
                ":title" => $this->title,
                ":subtitle" => $this->subtitle,
                ":description" => $this->description,
                ":price" => $this->price,
                ":id" => $this->id
            ]);
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

        // Supprimer un service :
        public function deleteService()
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









