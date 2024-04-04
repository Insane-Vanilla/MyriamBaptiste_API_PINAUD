<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json;charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: POST");

    require_once '../../config/Database.php';
    require_once '../../Models/Reviews.php';

    // Si la méthode de requête est POST
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Review :
        $review = new Review($db);

        //Récupération infos envoyées :
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->name) && !empty($data->content))
        {
            //Hydratation de l'objet review
            $review->name = htmlspecialchars($data->name);
            $review->content = htmlspecialchars($data->content);

            $result = $review->addReview();
            if($result) {
                http_response_code(201);
                echo json_encode(['message'=> "L'avis a été ajouté avec succès à votre site."]);
            } else {
                http_response_code(503);
                echo json_encode(['message'=> "L'ajout de l'avis a échoué.'"]);
            }
        } else {
            echo json_encode(['message'=> "Il manque des données."]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['message'=> "La méthode n'est pas autorisée."]);
    }


    

