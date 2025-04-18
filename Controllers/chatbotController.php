<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/userModel.php';

class ChatBotController {

    public function read() {
        require_once __DIR__ . "/../Includes/head.php";
        echo('test chat');

        include __DIR__ . '/../Views/user.php';
    }

}

?>