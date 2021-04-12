<?php
namespace Entity;

use Manager\DbManager;
use Manager\DbManagerInterface;

/**
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class Player implements DbManagerInterface
{
    /**@var string */
    private const TABLE = 'players';

    // Propriétés / Attributs
    /** @var int|null */
    private ?int $id;

    /** @var string */
    private string $name;

    /** @var int */
    private int $score;

    /** @var Character */
    private ?Character $character = null;

    /** @var Character[] */
    private array $characters = [];

    /**
     * @param  string $sName
     * @return void
     */
    public function __construct(string $sName)
    {
        $this->id = null;
        $this->score = 0;
        $this->name = $sName;
    }

    /**
     * @return array
     */
    public static function loadAll() : array
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('SELECT id, name, score FROM `'. self::TABLE .'` ORDER BY `score` DESC');
        $oStmt->execute();

        // On récupère toutes les lignes
        $aPlayers = [];
        while ($aData = $oStmt->fetch()) {
            $oPlayer = new Player( $aData['name'], '' );
            $oPlayer->setScore($aData['score']);

            $aPlayers[] = $oPlayer;
        }

        return $aPlayers;
    }

    /**
     * @param int $iId
     *
     * @return object
     */
    public static function get(int $iId) : ?object
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('SELECT id, name, score FROM `'. self::TABLE .'` WHERE id = :id');
        $oStmt->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oStmt->execute();

        // On récupère la première ligne
        $aData = $oStmt->fetch();
        if (!$aData) {
            // Condition de sortie : aucun utilisateur valide
            return null;
        }

        return self::hydrate($aData);
    }

    /**
     * @param string $sName
     *
     * @return object
     */
    public static function getByName(string $sName) : ?object
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('SELECT id, name, score FROM `'. self::TABLE .'` WHERE name = :name');
        $oStmt->bindValue(':name', $sName, \PDO::PARAM_STR);
        $oStmt->execute();

        // On récupère la première ligne
        $aData = $oStmt->fetch();
        if (!$aData) {
            // Condition de sortie : aucun utilisateur valide
            return null;
        }

        return self::hydrate($aData);
    }

    /**
     * Fonction d'hydratation (permet de remplir un objet via un tableau de données)
     * @param array $aData
     *
     * @return Player
     */
    private static function hydrate(array $aData)
    {
        $oPlayer = new Player($aData['name'], '');
        $oPlayer->setId($aData['id']);
        $oPlayer->setScore($aData['score']);
        $oPlayer->setCharacters(Character::loadAllByPlayer($oPlayer));

        return $oPlayer;
    }

    public function save() : void
    {
        // $this = mon Player à enregistrer
        $oPdo = DbManager::getDb();

        // Est-ce que mon Player existe en base ?
        if ($this->getId()) {
            // >> Si oui : UPDATE (> score)
            $oStmt = $oPdo->prepare('UPDATE `'. self::TABLE .'` SET score = :score WHERE id = :id');
            $oStmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $oStmt->bindValue(':score', $this->score, \PDO::PARAM_INT);
            $oStmt->execute();
        } else {
            // >> Si non : INSERT INTO (> name, score)
            $oStmt = $oPdo->prepare('INSERT INTO `'. self::TABLE .'` ( name, score ) VALUES (:name, :score)');
            $oStmt->bindValue(':name', $this->name, \PDO::PARAM_STR);
            $oStmt->bindValue(':score', $this->score, \PDO::PARAM_INT);
            $oStmt->execute();

            // On stocke l'id AUTO_INCREMENT
            $this->setId($oPdo->lastInsertId());
        }

        // Enregistrement du Character
        if ($this->character instanceof Character) {
            $this->getCharacter()->save();
        }
    }

    public function delete() : void
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('DELETE FROM `'. self::TABLE .'` WHERE id = :id');
        $oStmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $oStmt->execute();

        // Suppression des personnages du joueur
        foreach ($this->characters as $oCharacter) {
            $oCharacter->delete();
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    // Comportements / Fonctions

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @return  self
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set the value of character
     *
     * @return  self
     */
    public function setCharacter($character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * @return Character[]
     */
    public function getCharacters(): array
    {
        return $this->characters;
    }

    /**
     * @param Character[] $characters
     *
     * @return Player
     */
    public function setCharacters(array $characters): Player
    {
        $this->characters = $characters;
        return $this;
    }
}
