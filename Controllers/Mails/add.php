<?php

    // Les application qui peuvent avoir accès à l'API :
    header("Access-Control-Allow-Origin: *");
    // Le format dans lequel les données sont fournies /récupérées:
    header("Content-type:application/json;charset= UTF-8");
    // La méthode autorisée ici :
    header("Access-Control-Allow-Methods: POST");
    //
    header("Access-Control-Allow-Headers : *");


    require_once '../../config/Database.php';
    require_once '../../Models/Mails.php';

    // Si la méthode de requête est POST
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        // Instanciation BDD :
        $database = new Database();
        $db = $database->getConnection();

        //Instanciation objet Mail :
        $mail = new Mail($db);

        //Récupération infos envoyées :
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->lastname) && !empty($data->firstname) && !empty($data->phone) && !empty($data->email) && !empty($data->message))
        {
            //Hydratation de l'objet Mail
            $mail->lastname = htmlspecialchars($data->lastname);
            $mail->firstname = htmlspecialchars($data->firstname);
            $mail->phone = htmlspecialchars($data->phone);
            $mail->email = htmlspecialchars($data->email);
            $mail->message = htmlspecialchars($data->message);

            $result = $mail->addMail();
            if($result) {
                http_response_code(201);
                echo json_encode(['message'=> "Le mail a été envoyé."]);
            } else {
                http_response_code(503);
                echo json_encode(['message'=> "L'envoi du mail a échoué.'"]);
            }
        } else {
            echo json_encode(['message'=> "Il manque des données."]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['message'=> "La méthode n'est pas autorisée."]);
    }


    

