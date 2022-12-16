<?php

include __DIR__ .'/mysqlConnection.php';

class UploadFileAction {

    public function addFileToDB($title) {
        $db = Model::getDB();
        
        $id = $_SESSION['user_id'];
        $sql_insert_user =  'INSERT INTO files VALUES (null, :user_id, :title)';
        
        $stmt_user = $db->prepare($sql_insert_user);

        $stmt_user->bindValue(':user_id', $id, PDO::PARAM_INT);
        $stmt_user->bindValue(':title', $title, PDO::PARAM_STR);
        // $stmt_user->bindValue(':file', $pdfFile, PDO::PARAM_LOB);
        $stmt_user->execute();
    }

    public function displayFilesRelatedToCurrentUser() {
        $db = Model::getDB();

        $id = $_SESSION['user_id'];

        $sql_select_files = "SELECT id, title FROM files WHERE user_id = '$id'";
        
        $stmt = $db->prepare($sql_select_files);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function displayFiles($fileId) {
        $db = Model::getDB();

        $id = $_SESSION['user_id'];

        $sql_select_files = "SELECT id, title, file FROM files WHERE user_id = '$id' AND id = '$fileId' LIMIT 1";
        
        $stmt = $db->prepare($sql_select_files);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>