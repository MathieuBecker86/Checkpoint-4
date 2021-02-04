<?php

namespace App\Model;

class ContactManager extends AbstractManager
{

    public const TABLE = 'contact';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function insert(array $contact): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`firstname`, `lastname`,
             `email`, `message`, `date`) 
            VALUES (:firstname, :lastname, :email, :message, :date)"
        );
        $statement->bindValue('firstname', $contact['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $contact['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $contact['email'], \PDO::PARAM_STR);
        $statement->bindValue('message', $contact['message'], \PDO::PARAM_STR);
        $statement->bindValue('date', date("Y-n-d"), \PDO::PARAM_STR);

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
