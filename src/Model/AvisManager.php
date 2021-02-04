<?php

namespace App\Model;

class AvisManager extends AbstractManager
{
    /**
     *
     */
    public const TABLE = 'avis';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function insert(array $avis): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`nom`, `titre`, `note`, `commentaire`, `date`)
         VALUES (:nom, :titre, :note, :commentaire, :date)"
        );
        $statement->bindValue('nom', $avis['nom'], \PDO::PARAM_STR);
        $statement->bindValue('titre', $avis['titre'], \PDO::PARAM_STR);
        $statement->bindValue('note', $avis['note'], \PDO::PARAM_INT);
        $statement->bindValue('commentaire', $avis['commentaire'], \PDO::PARAM_STR);
        $statement->bindValue('date', date("Y-n-d"), \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }




    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function update(array $avis): bool
    {

        // prepared request
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE . " SET nom= :nom,titre= :titre,note= :note,
        commentaire= :commentaire,date= :date WHERE id=:id"
        );
        $statement->bindValue('id', $avis['id'], \PDO::PARAM_INT);
        $statement->bindValue('nom', $avis['nom'], \PDO::PARAM_STR);
        $statement->bindValue('titre', $avis['titre'], \PDO::PARAM_STR);
        $statement->bindValue('note', $avis['note'], \PDO::PARAM_INT);
        $statement->bindValue('commentaire', $avis['commentaire'], \PDO::PARAM_STR);
        $statement->bindValue('date', $avis['date'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
