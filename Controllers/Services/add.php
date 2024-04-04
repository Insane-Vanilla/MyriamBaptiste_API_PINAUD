<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json;charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: POST");

    require_once '../../config/Database.php';
    require_once '../../Models/Services.php';

    // Si la méthode de requête est POST
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Service :
        $service = new Service($db);

        //Récupération infos envoyées :
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->category) && !empty($data->title) && !empty($data->subtitle) 
        && !empty($data->description) && !empty($data->price))
        {
            //Hydratation de l'objet Service
            $service->category = htmlspecialchars($data->category);
            $service->title = htmlspecialchars($data->title);
            $service->subtitle = htmlspecialchars($data->subtitle);
            $service->description = htmlspecialchars($data->description);
            $service->price = htmlspecialchars($data->price);

            $result = $service->addService();
            if($result) {
                http_response_code(201);
                echo json_encode(['message'=> "Le service a été ajouté avec succès à votre site."]);
            } else {
                http_response_code(503);
                echo json_encode(['message'=> "L'ajout du service a échoué.'"]);
            }
        } else {
            echo json_encode(['message'=> "Il manque des données."]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['message'=> "La méthode n'est pas autorisée."]);
    }


    

