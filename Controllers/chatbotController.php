<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/userModel.php';

class ChatBotController {

    public function read() {
        require_once __DIR__ . "/../Includes/head.php";
        
        // Inclusion de la vue
        include __DIR__ . '/../Views/chat.php';
    }

}

?>