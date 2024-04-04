<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json; charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: PUT");

    require_once '../../config/Database.php';
    require_once '../../Models/Services.php';

    // Si la méthode de requête est PUT
    if ($_SERVER['REQUEST_METHOD'] === "PUT") {

        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Service :
        $service = new Service($db);

        //Récupération infos envoyées :
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->id) && !empty($data->category) && !empty($data->title) && !empty($data->subtitle) && !empty($data->description) && !empty($data->price)) {
            // Hydratation objet service :
            $service->id = intval($data->id);
            $service->category = htmlspecialchars($data->category);
            $service->title = htmlspecialchars($data->title);
            $service->subtitle = htmlspecialchars($data->subtitle);
            $service->description = htmlspecialchars($data->description);
            $service->price = htmlspecialchars($data->price);

            $result = $service->updateService();
            if($result) {
                http_response_code(201);
                echo json_encode(['message'=> "Le service a été modifié avec succès."]);
            } else {
                http_response_code(503);
                echo json_encode(['message'=> "La modification du service a échoué.'"]);
            }
        } else {
            echo json_encode(['message'=> "Il manque des données."]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['message'=> "La méthode n'est pas autorisée."]);
    }

    
    

