<?php

include __DIR__ .'/loginAction.php';

class EditModel {
    public function selectUsername()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT username 
                FROM users 
                WHERE id = $id
                ";

        $db = Model::getDb();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function selectEmail()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT email 
                FROM users
                WHERE id = $id
                ";

        $db = Model::getDb();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function deleteUserAccount()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                DELETE FROM users
                WHERE id = :id
                ";

        $db = Model::getDb();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $result = $stmt->fetchAll();
        $stmt->execute();

        return $result;
    }

    public function updateUserAccount($username, $email)
    {
        try {

            if (empty($this->errors)) {

                $id = $_SESSION['user_id'];

                $sql = "
                        UPDATE users
                        SET username = '$username', email = '$email'
                        WHERE id = :id
                        ";

                $db = Model::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':id', $id, PDO::PARAM_INT);

                $result = $stmt->fetchAll();
                $stmt->execute();

                return $result;
            }
        } catch (\Exception $exception) {

            echo $exception;
        }

    }

    public function editPassword($currentPassword, $newPassword, $confirmNewPassword)
    {
        $id = $_SESSION['user_id'];

        $currentPasswordFromDB = $this->selectPassword();
        $newVar = $currentPasswordFromDB[0][0];

        if (password_verify($currentPassword, $newVar) && $newPassword == $confirmNewPassword) {

            $newPassword_hash = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "
                UPDATE users 
                SET password = '$newPassword_hash'  
                WHERE id = :id
                ";

            $db = Model::getDb();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $result = $stmt->fetchAll();
            $stmt->execute();

            return true;
        }

        return false;

    }

    private static function selectPassword()
    {
        $id = $_SESSION['user_id'];

        $sql = "
                SELECT password 
                FROM users 
                WHERE id = :id
                ";

        $db = Model::getDb();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}

class EditAction {
    public function updateUserAccountAction($newUsername, $newEmail)
    {
        $user = new EditModel();
        $user->updateUserAccount($newUsername, $newEmail);
    }

    public function editPasswordAction($oldPassword, $newPassword, $newRepeatedPassoword)
    {
        $reset = new EditModel();

        if ($reset->editPassword($oldPassword, $newPassword, $newRepeatedPassoword)) {

            dump('haslo zmienione');


        } else {

            dump('Nie udalo sie zmienic hasla');

        }
    }
}

?>