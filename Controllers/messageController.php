<?php
// Inclusion des fichiers nécessaires
// db.php contient la connexion à la base de données
// userModel.php contient les fonctions pour interagir avec la base de données
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/userModel.php';

/**
 * MessageController : Gère toutes les interactions avec le chat
 * Cette classe s'occupe de :
 * - Recevoir les messages de l'utilisateur
 * - Chercher les réponses appropriées
 * - Stocker l'historique du chat
 * - Envoyer les réponses au navigateur
 */
class MessageController {
    /**
     * Méthode message() : Traite les messages entrants et génère les réponses
     * Cette méthode est appelée à chaque fois que l'utilisateur envoie un message
     */
    public function message() {
        // Démarre la session si elle n'est pas déjà active
        // La session permet de garder l'historique du chat entre les requêtes
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Initialise le tableau de chat dans la session s'il n'existe pas
        $_SESSION['chat'] = $_SESSION['chat'] ?? [];

        // Récupère le message de l'utilisateur et le nettoie
        // strtolower() : convertit en minuscules
        // trim() : enlève les espaces au début et à la fin
        $message = strtolower(trim($_POST['message'] ?? ''));
        // Crée une instance de UserModel pour accéder à la base de données
        $userModel = new UserModel();

        try {
            // Vérifie si le message n'est pas vide
            if (!empty($message)) {
                // Récupère tous les mots-clés de la base de données
                $keywords = $userModel->getAllKeywords();
                $found = []; // Tableau pour stocker les IDs des mots-clés trouvés

                // Parcourt tous les mots-clés pour voir si le message en contient
                foreach ($keywords as $keyword) {
                    // stripos() cherche si le mot-clé est dans le message (insensible à la casse)
                    if (stripos($message, strtolower($keyword['mot_cle'])) !== false) {
                        $found[] = $keyword['id']; // Ajoute l'ID du mot-clé trouvé
                    }
                }

                // Ajoute le message de l'utilisateur à l'historique du chat
                $_SESSION['chat'][] = [
                    'type'    => 'user', // Type 'user' pour les messages de l'utilisateur
                    'content' => $message // Le contenu du message
                ];

                // Si des mots-clés ont été trouvés
                if ($found) {
                    // Récupère toutes les réponses associées aux mots-clés trouvés
                    $responses = $userModel->getAllResponseFromKeyword($found);
                    // Ajoute chaque réponse à l'historique du chat
                    foreach ($responses as $text) {
                        $_SESSION['chat'][] = [
                            'type'    => 'bot', // Type 'bot' pour les réponses du robot
                            'content' => $text // Le contenu de la réponse
                        ];

                        //si la réponse contient cette phrase:
                        if ($text === "Souhaitez-vous voir notre catalogue ?") {
                            $_SESSION['catalog'] = true; //on initialise une session catalog
                        }

                        if ($text === "Vous souhaitez contacter le service après vente ?") {
                            $_SESSION['sav'] = true; //on initialise une session catalog
                        }
                    }
                    if (isset($_SESSION['sav']) && $_SESSION['sav'] && $message === 'oui') { //si la session catalog
                            unset($_SESSION['sav']); //supprime la session 
                            
                            $text = "Pour joindre notre service après vente, vous pouvez contacter le 0865342154 munit de votre numéro de commande"; //le nom, le prix et description
                            $_SESSION['chat'][] = [ //le produit sera envoyé en réponse par le bot
                                'type'    => 'bot',
                                'content' => $text
                            ];
                        }
                         elseif (isset($_SESSION['catalog']) && $_SESSION['catalog'] && $message === 'oui') { //si la session catalog
                            unset($_SESSION['catalog']); //supprime la session 

                            $catalog = $userModel->getCatalog(); //fonction qui affiche tous les produits

                            if(!empty($catalog)) { //si catalogue n'est pas vide
                                foreach($catalog as $product) { // pour chaque produit on affiche:
                                    $imageName = rawurlencode($product['image']);
                                    $url = "http://localhost/sneak-me/user";
                                    $newUrl = str_replace("user", "sneak-me/Public/uploads/", $url);
                                    $imageUrl = $newUrl . $imageName;

                                    $text = "Produit : {$product['title']}\nPrix : {$product['price']} €\nDescription : {$product['description']} \nImage : "; //le nom, le prix et description
                                    $text .= "<img src='{$imageUrl}' alt='{$product['title']}' style='height: 150px'>";
                                    $_SESSION['chat'][] = [ //le produit sera envoyé en réponse par le bot
                                        'type'    => 'bot',
                                        'content' => $text
                                    ];
                                } 
                            } else { //sinon on affiche un message par défaut
                                    $_SESSION['chat'][] = [
                                        'type'    => 'bot',
                                        'content' => "Le catalogue est vide pour le moment."
                                    ];
                                }
                        }
                        
                }  
                else {
                    // Si aucun mot-clé n'a été trouvé, envoie un message par défaut
                    $_SESSION['chat'][] = [
                        'type'    => 'bot',
                        'content' => "Désolé, je n'ai pas compris votre demande."
                    ];
                }
            }
        } catch (Throwable $e) {
            // En cas d'erreur, ajoute un message d'erreur à l'historique
            $_SESSION['chat'][] = [
                'type'    => 'bot',
                'content' => "Une erreur est survenue : " . $e->getMessage()
            ];
        }

        // Vérifie si la requête est une requête AJAX (JavaScript)
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            // Si c'est une requête AJAX, renvoie les données en JSON 
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($_SESSION['chat'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Si ce n'est pas une requête AJAX, affiche la page de chat
        $responses = $_SESSION['chat'];
        include_once __DIR__ . '/../Views/chat.php';
    }


    //Méthode clear() : Vide l'historique du chat
     
    public function clear() {
        // Démarre la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Supprime l'historique du chat
        unset($_SESSION['chat']);

        // Renvoie un tableau vide en JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([], JSON_UNESCAPED_UNICODE);
        exit;
    }
}