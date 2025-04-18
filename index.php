<?php
session_start();

define("URL", str_replace("index.php", "",(isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]
));

require_once __DIR__ . "/Controllers/messageController.php";
require_once __DIR__ . "/Controllers/chatbotController.php";

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
        $chatbotController->read();
    break;
    case "message":
        $messageController->message();
    break;
    default:
      echo "404 Page non trouvée";
    break;
  }

} catch (Exception $e) { 
  echo "500 : Erreur interne du serveur.";
}

?>