<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Includes/head.php';
require_once __DIR__ . '/../Models/userModel.php';

class MessageController {

    public function message() {
        require_once __DIR__ . "/../Includes/head.php";

        $message = strtolower(trim(($_POST['message-user'])));
        $responses = [];
        $userModel = new UserModel();

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($message)) {
                $keywords = $userModel->getAllKeywords();
                $found = [];

                foreach ($keywords as $keyword) {
                    if (stripos($message, $keyword['keyword_name']) !== false) {
                        $found[] = $keyword['id'];
                    }
                }

                if ($found) {
                    $responses = $userModel->getAllResponseFromKeyword($found);
                } else {
                    echo("Aucun résultat");
                }
            } 
        } catch (Throwable $e) {
            echo "Une erreur est survenue : " . $e->getMessage();
        }

        include __DIR__ . '/../Views/user.php';
    } 
        

       
    }

?>