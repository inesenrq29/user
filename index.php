<?php
session_start();

define("URL", str_replace("index.php", "",(isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]
));

require_once __DIR__ . "/Controllers/messageController.php";
require_once __DIR__ . "/Controllers/chatbotController.php";

$messageController = new MessageController();
$chatbotController = new ChatbotController();

try {
    // Vérifier si c'est une requête POST avec un contrôleur et une action
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['controller']) && isset($_POST['action'])) {
        $controller = $_POST['controller'];
        $action = $_POST['action'];
        
        switch($controller) {
            case "message":
                $messageController->$action();
                break;
            default:
                echo "404 Contrôleur non trouvé";
                break;
        }
    } else if(empty($_GET['page'])) {
        $chatbotController->read();
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        $page = $url[0];

        switch($page) {
            case "message":
                $messageController->message();
                break;
            default:
                echo "404 Page non trouvée";
                break;
        }
    }
} catch (Exception $e) { 
    echo "500 : Erreur interne du serveur.";
}
?>