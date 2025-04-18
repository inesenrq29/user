<?php
session_start();

require_once __DIR__ . "/Controllers/messageController.php";
require_once __DIR__ . "/Controllers/chatbotController.php";
require_once __DIR__ . "/Views/chat.php";

define("URL", str_replace("index.php", "",(isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]
));

$messageController = new MessageController();
$chatbotController = new ChatbotController();


try {
  if(empty($_GET['page'])){
    $page = "";
  }else {
    $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
    $page = $url[0];
  }

  switch($page){
    case "":
        case "chatbot":
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                $chatbotController->read();
            }
            break;
    case "message":
      if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        $messageController->message();
      }
      break;
    default:
      echo "404 Page non trouvée";
      break;
  }

} catch (Exception $e) { 
  echo "500 : Erreur interne du serveur.";
}

?>