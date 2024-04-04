<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json; charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: PUT");

    require_once '../../config/Database.php';
    require_once '../../Models/Reviews.php';

    // Si la méthode de requête est PUT
    if ($_SERVER['REQUEST_METHOD'] === "PUT") {

        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Review :
        $review = new Review($db);
 
        //Récupération infos envoyées :
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->id) && !empty($data->name) && !empty($data->content)) {
            // Hydratation objet Review :
            $review->id = intval($data->id);
            $review->name = htmlspecialchars($data->name);
            $review->content= htmlspecialchars($data->content);

            $result = $review->updateReview();
            if($result) {
                http_response_code(201);
                echo json_encode(['message'=> "L'avis' a été modifié avec succès."]);
            } else {
                http_response_code(503);
                echo json_encode(['message'=> "La modification de l'avis a échoué.'"]);
            }
        } else {
            echo json_encode(['message'=> "Il manque des données."]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['message'=> "La méthode n'est pas autorisée."]);
    }

    
    

