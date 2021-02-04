<?php

namespace App\Model;

class ReservationManager extends AbstractManager
{
    /**
     *
     */
    public const TABLE = 'reservation';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $reservation): int
    {
        // prepared request

        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (id_client, date, montant, commentaire,validation)
         VALUES (:id_client, :date, :montant, :commentaire, :validation)"
        );
        $statement->bindValue(':date', $reservation['date'], \PDO::PARAM_STR);
        $statement->bindValue(':montant', $reservation['montant'], \PDO::PARAM_STR);
        $statement->bindValue(':validation', $reservation['validation'], \PDO::PARAM_INT);
        $statement->bindValue(':commentaire', $reservation['commentaire'], \PDO::PARAM_STR);
        $statement->bindValue(':id_client', $reservation['id_client'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $item): bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `date` = :date WHERE id=:id");
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('date', $item['date'], \PDO::PARAM_STR);

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
