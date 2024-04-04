<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json; charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: GET");

    require_once '../../config/Database.php';
    require_once '../../Models/Mails.php';

    // Si la méthode de requête est GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Mail :
        $mail = new Mail($db);

        //Récupération des données :
        $statement = $mail->getMails();

        if($statement->rowCount() > 0) {
            $data = [];
            $data = $statement->fetchAll();

            // Renvoi données au format json
            http_response_code(200);
            echo json_encode($data);
        } else {
            echo json_encode(["message" => "Aucune donnée à envoyer"]);
        }
    } else {
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
    }

    


