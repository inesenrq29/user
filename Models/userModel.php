<?php
require_once __DIR__ . '/../Includes/db.php';

class UserModel {

    public function getAllKeywords() {
        $pdo = getConnection();

        // Requête SQL pour récupérer les mots-clés, leurs réponses ainsi que leurs IDs respectifs
        $stmt = $pdo->query('
            SELECT * FROM keyword');

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne tous les éléments sous forme de tableau associatif
    }
}
?>

