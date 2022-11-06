<?php
    include __DIR__ .'/mysqlConnection.php';

    class Registration {
        private string $name;
        private string $userPassword;
        private string $email;
    
        public function __construct($nname, $uuserPassword, $eemail) {
            $this->name = $nname;
            $this->userPassword = $uuserPassword;
            $this->email = $eemail;
        }
    
        public function addUserToDatabase() {
            // $this->validate();
            if (empty($this->errors)) {
                $password_hash = password_hash($this->userPassword, PASSWORD_DEFAULT);
                dump($password_hash);
                $db = Model::getDB();
                dump($db);

                $sql_insert_user = 'INSERT INTO users VALUES (null, :username, :password, :email)';

                dump($this->name);
                $stmt_user = $db->prepare($sql_insert_user);
    
                $stmt_user->bindValue(":username", $this->name, PDO::PARAM_STR);
                $stmt_user->bindValue(":password", $password_hash, PDO::PARAM_STR);
                $stmt_user->bindValue(":email", $this->email, PDO::PARAM_STR);
                dump($this->email);
                dump($stmt_user);
                $stmt_user->execute();
            }
    
            return false;
        }
    
        private function validate() {
            // name
            if ($this->name == '') {
                $this->errors[] = 'Name is required';
            }
    
            // email address
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
                $this->errors[] = 'Invalid email';
            }
    
            if ($this->emailExists($this->email, $this->id ?? null)) {
                $this->errors[] = 'email already taken';
            }
    
            // Password
            if (isset($this->userPassword)) {
                // if ($this->userPassword != $this->repeatedUserPassword) {
                //     $this->errors[] = 'Password must match confirmation.';
                // }
    
                if (strlen($this->userPassword) < 6) {
                    $this->errors[] = 'Please enter at least 6 characters for the password';
                }
    
                if (preg_match('/.*[a-z]+.*/i', $this->userPassword) == 0) {
                    $this->errors[] = 'Password needs at least one letter';
                }
    
                if (preg_match('/.*\+.*/i', $this->userPassword) == 0) {
                    $this->errors[] = 'Password needs at least one number';
                }
            }
        }
    
        public function emailExists($email, $ignore_id = null) {
            $user = $this->findByEmail($email);
    
            if ($user) {
                if ($user->id != $ignore_id) {
                    return true;
                }
            }
    
            return false;
        }
    
        public function findByEmail($email) {
            $sql = 'SELECT * FROM users WHERE email = :email';
    
            $db = Model::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    
            $stmt->execute();
    
            return $stmt->fetch();
        }
    
        public function authenticate($email, $password) {
            $user = $this->findByEmail($email);
    
            if ($user) {
                if (password_verify($password, $user->password)) {
                    return $user;
                }
            }
    
            return false;
        }
    }


?>