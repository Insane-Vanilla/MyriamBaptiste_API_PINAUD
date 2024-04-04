<?php

    class Review
    {
        private $table ="reviews";
        private $connection = null;

        // Les propriétés de l'objet "review"
        public $id;
        public $name;
        public $content;

        public function __construct($db)
        {
            if ($this->connection == null) {
                $this->connection = $db;
            }
        }
        
        // Récupérer la table "reviews" :
        public function getReviews()
        {
            $sql = "SELECT * FROM $this->table";
            $req = $this->connection->query($sql);
            return $req;
        }

        // Ajouter un avis :
        public function addReview()
        {
            $sql = "INSERT INTO $this->table(name, content) VALUES (:name, :content)";
            $req = $this->connection->prepare($sql);
            $re= $req->execute([
                ":name" => $this->name,
                ":content" => $this->content
            ]);
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

        // Modifier un avis :
        public function updateReview()
        {
            $sql="UPDATE $this->table SET name=:name, content=:content WHERE id=:id";
            $req = $this->connection->prepare($sql);
            $re= $req->execute([
                ":name" => $this->name,
                ":content" => $this->content,
                ":id" => $this->id
            ]);
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

        // Supprimer un avis :
        public function deleteReview()
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









