<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Includes/head.php';
require_once __DIR__ . '/../Models/userModel.php';

class MessageController {

    public function message() {
        require_once __DIR__ . "/../Includes/head.php";
        echo('test message');

        include __DIR__ . '/../Views/user.php';
    }

}

?>