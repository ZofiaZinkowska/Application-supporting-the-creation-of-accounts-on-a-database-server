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

    public static function findById($id) {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }
}

class Login {
    public static function login($user) {
        
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user->id;
    }

    public static function logout() {
        $_SESSION = [];
    }

    public static function getUser() {
        if (isset($_SESSION['user_id'])) {
            return User::findById($_SESSION['user_id']);
        }
    }

    public function loginAction() {
        $user = User::authenticate($_POST['email'], $_POST['password']);

        if ($user) {
            $_SESSION['id'] = $user->id;

            static::login($user);
            // $this->redirect('/stronaglowna')
        } else {
            // dump('niepoprawne logowanie')
        }
    }

}

?>