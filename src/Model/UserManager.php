<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function findAll()
    {
        $statement = $this->pdo->prepare("SELECT * FROM user ");
        $statement->execute();
        return $statement->fetchall();
    }

    public function findOneById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM `user` WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function createAccount(array $user)
    {
        // session_start();

        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $email = strip_tags($_POST['email']);
        $adress = strip_tags($_POST['adress']);
        $password = strip_tags($_POST['password']);
        $passwordHash  = password_hash($password, PASSWORD_ARGON2ID);

        $statement = $this->pdo->prepare("INSERT INTO user (firstname, lastname, email, adress, password ) VALUES (:firstname, :lastname, :email, :adress, :password)");
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':adress', $adress, \PDO::PARAM_STR);
        $statement->bindValue(':password', $passwordHash, \PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }



    public function updateAccount($user)
    {
        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $email = strip_tags($_POST['email']);
        $adress = strip_tags($_POST['adress']);
        $password = strip_tags($_POST['password']);
        $passwordHash  = password_hash($password, PASSWORD_ARGON2ID);

        $statement = $this->pdo->prepare("UPDATE user SET id=:id, firstname =:firstname, lastname =:lastname, email =:email, adress =:adress, password =:password
         WHERE id=:id");
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':adress', $adress, \PDO::PARAM_STR);
        $statement->bindValue(':password', $passwordHash, \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function deleteById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM user WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function login(array $login)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email = (:email)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $login['email'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function emailCheck(array $email)
    {
        $query = "SELECT email FROM " . self::TABLE . " WHERE email = (:email)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $email['email'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn();
    }

    // public function verifyEmail()
    // {
    //     $statement = $this->pdo->prepare("SELECT email FROM `user` ");
    //     $statement->execute();
    //     return $statement->fetchAll();
    // }


    // public function verifyPassword()
    // {
    //     $statement = $this->pdo->prepare("SELECT password FROM `user` ");
    //     $statement->execute();
    //     return $statement->fetchAll();
    // }

    // /**
    //  * TODO
    //  */
    // public function testVerifEmail()
    // {

    //     // $email = strip_tags($_POST['email']);
    //     // var_dump($email);

    //     $statement = $this->pdo->prepare("SELECT email FROM `user` ");
    //     $statement->execute();
    //     return $statement->fetchAll();
    // }
}