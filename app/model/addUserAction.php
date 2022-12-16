<?php

include __DIR__ .'/mysqlConnection.php';

class AddUserModel {
    private string $login;
    private string $userType;
    private string $registered;
    private string $magic;
    private string $date;

    public function __construct($llogin, $uuserType, $rregistered, $mmagic, $ddate) {
        $this->login = $llogin;
        $this->userType = $uuserType;
        $this->registered = $rregistered;
        $this->magic = $mmagic;
        $this->date = $ddate;
    }

    public function addUserToDatabase() {
        // $this->validate();
        $db = Model::getDB();

        $sql_insert_user = 'INSERT INTO accounts VALUES (null, :login, :userType, :registered, :magic, :date)';

        $stmt_user = $db->prepare($sql_insert_user);

        $stmt_user->bindValue(":login", $this->login, PDO::PARAM_STR);
        $stmt_user->bindValue(":userType", $this->userType, PDO::PARAM_INT);
        $stmt_user->bindValue(":registered", $this->registered, PDO::PARAM_INT);
        $stmt_user->bindValue(":magic", $this->magic, PDO::PARAM_STR);
        $stmt_user->bindValue(":date", $this->date, PDO::PARAM_STR);
        $stmt_user->execute();
    }
}

class AddUserAction {

}

?>