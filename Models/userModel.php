<?php
require_once __DIR__ . '/../Includes/db.php';

class UserModel {

    public function getAllKeywords() {
        $db = getConnection();
        $sql = "SELECT k.id, k.keyword_name as mot_cle, r.response_name as reponse 
                FROM keyword k
                LEFT JOIN keyword_response kr ON k.id = kr.keyword_id
                LEFT JOIN response r ON kr.response_id = r.id";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllResponseFromKeyword($keywordIds) {
        $db = getConnection();
        $placeholders = str_repeat('?,', count($keywordIds) - 1) . '?';
        $sql = "SELECT DISTINCT r.response_name as reponse 
        FROM response r
        INNER JOIN keyword_response kr ON r.id = kr.response_id
                WHERE kr.keyword_id IN ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($keywordIds);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>

