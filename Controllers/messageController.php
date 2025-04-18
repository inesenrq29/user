<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Includes/head.php';
require_once __DIR__ . '/../Models/userModel.php';

class MessageController {

    public function message() {
        // Initialisation de la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Initialisation des variables de session
        $_SESSION['chat'] = $_SESSION['chat'] ?? [];

        $message = strtolower(trim($_POST['message'] ?? ''));
        $userModel = new UserModel();

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($message)) {
                $keywords = $userModel->getAllKeywords();
                
                $found = [];
                foreach ($keywords as $keyword) {
                    if (stripos($message, strtolower($keyword['mot_cle'])) !== false) {
                        $found[] = $keyword['id'];
                    }
                }

                $_SESSION['chat'][] = [
                    'type' => 'user',
                    'content' => $message
                ];

                if ($found) {
                    $responseTexts = $userModel->getAllResponseFromKeyword($found);
                    
                    foreach ($responseTexts as $text) {
                        $_SESSION['chat'][] = [
                            'type' => 'bot',
                            'content' => $text
                        ];
                    }
                } else {
                    $_SESSION['chat'][] = [
                        'type' => 'bot',
                        'content' => "Désolé, je n'ai pas compris votre demande."
                    ];
                }
            }

            $responses = $_SESSION['chat'];
        } catch (Throwable $e) {
            $_SESSION['chat'][] = [
                'type' => 'bot',
                'content' => "Une erreur est survenue : " . $e->getMessage()
            ];
            $responses = $_SESSION['chat'];
        }

        include_once __DIR__ . '/../Views/chat.php';
    }
}