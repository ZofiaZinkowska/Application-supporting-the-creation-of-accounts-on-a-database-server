<?php

include __DIR__ .'/mysqlConnection.php';

class User {
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);
        
        if($user/* && $user->is_active*/){
            if(password_verify($password, $user->password)){
                return $user;
            }
        }
        
        return false;
    }

    public static function emailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);

        if($user) {
            if($user->id != $ignore_id){
                return true;
            }
        }

        return false;
    }

    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function findByUUID($uuid)
    {
        $sql = 'SELECT id FROM users WHERE reset_password = :uuid';

        $db = Model::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':uuid', $uuid, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getUUID($email)
    {
        $sql = 'SELECT reset_password FROM users WHERE email = :email';

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public static function findById($id) {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function updateUUIDtoResetPassword($email) {
        $uuid = User::guidv4();
        $sql = "
                UPDATE users 
                SET reset_password = '$uuid' 
                WHERE email = :email
                ";
        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $result = $stmt->fetch();
        $stmt->execute();

        return true;
    }

    public function resetPassword($password, $id) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "
                UPDATE users 
                SET password = '$password_hash', reset_password = NULL
                WHERE id = :id
                ";
        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        $result = $stmt->fetch();
        $stmt->execute();

        return true;
    }
}

class Login {
    public static function login($user) {
        
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user->id;
    }

    public static function logout() {
        $_SESSION = [];
        session_destroy();
    }

    public static function getUser() {
        if (isset($_SESSION['user_id'])) {
            return User::findById($_SESSION['user_id']);
        }
    }

    public static function loginAction() {
        $user = User::authenticate($_POST['email'], $_POST['password']);

        if ($user) {
            $_SESSION['user_id'] = $user->id;

            static::login($user);
            // $this->redirect('/stronaglowna')
        } else {
            // dump('niepoprawne logowanie')
        }
    }
}

?>