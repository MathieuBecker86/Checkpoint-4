<?php

namespace App\Model;

class UserManager extends AbstractManager
{

    public const TABLE = 'admin';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function login(array $login)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE username=:username AND password=:password"
        );
        $statement->bindValue('username', $login['username'], \PDO::PARAM_STR);
        $statement->bindValue('password', md5($login['password']), \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function insert(array $user): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`username`, `firstname`, `lastname`,
             `email`, `number`, `password`, `use_admin`) 
            VALUES (:username, :firstname, :lastname, :email, :number, :password, 0)"
        );
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('number', $user['number'], \PDO::PARAM_INT);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE . " SET username= :username,firstname= :firstname,lastname= :lastname,
        email= :email,number= :number,password= :password WHERE id=:id"
        );
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('number', $user['number'], \PDO::PARAM_INT);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

}

