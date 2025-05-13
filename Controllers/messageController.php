<?php
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/userModel.php';

class MessageController {
    public function message() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['chat'] = $_SESSION['chat'] ?? [];

        $message = strtolower(trim($_POST['message'] ?? ''));
        $userModel = new UserModel();

        try {
            if (!empty($message)) {

                $keywords = $userModel->getAllKeywords();
                $found = [];
                foreach ($keywords as $keyword) {
                    if (stripos($message, strtolower($keyword['mot_cle'])) !== false) {
                        $found[] = $keyword['id'];
                    }
                }


                $_SESSION['chat'][] = [
                    'type'    => 'user',
                    'content' => $message
                ];


                if ($found) {
                    $responses = $userModel->getAllResponseFromKeyword($found);
                    foreach ($responses as $text) {
                        $_SESSION['chat'][] = [
                            'type'    => 'bot',
                            'content' => $text
                        ];
                    }
                } else {
                    $_SESSION['chat'][] = [
                        'type'    => 'bot',
                        'content' => "Désolé, je n'ai pas compris votre demande."
                    ];
                }
            }
        } catch (Throwable $e) {
            $_SESSION['chat'][] = [
                'type'    => 'bot',
                'content' => "Une erreur est survenue : " . $e->getMessage()
            ];
        }

        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($_SESSION['chat'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $responses = $_SESSION['chat'];
        include_once __DIR__ . '/../Views/chat.php';
    }

    public function clear() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['chat']);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([], JSON_UNESCAPED_UNICODE);
        exit;
    }
}