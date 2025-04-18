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

    public function getAllResponseFromKeyword(array $ids) {
        $pdo = getConnection();
        $keyword_id = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT DISTINCT r.response_name 
        FROM response r
        INNER JOIN keyword_response kr ON r.id = kr.response_id
        WHERE kr.keyword_id IN ($keyword_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>

