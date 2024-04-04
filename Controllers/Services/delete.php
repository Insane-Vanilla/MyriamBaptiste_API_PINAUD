<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json;charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: DELETE");

    require_once '../../config/Database.php';
    require_once '../../Models/Services.php';

    // Si la méthode de requête est DELETE
    if($_SERVER['REQUEST_METHOD'] === "DELETE") {
        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Service :
        $service = new Service($db);

        //Récupération infos envoyées :
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->id)) {
            $service->id = $data->id;
            if ($service->deleteService()) {
                http_response_code(200);
                echo json_encode(array('message'=> "Le service a été supprimé avec succès."));
            } else {
                http_response_code(503);
                echo json_encode(array('message'=> "La suppression n'a pas été effectuée."));
            }
        } else {
            echo json_encode(['message'=> "Vous devez préciser l'identifiant du service à supprimer."]);
            }
    }
    else {
        http_response_code(405);
        echo json_encode(['message'=> "La méthode n'est pas autorisée."]);
    }




