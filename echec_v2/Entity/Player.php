<?php
namespace Entity;

use Manager\DbManager;

//use \Manager\DbManagerInterface;

/**
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class Player implements \Manager\DbManagerInterface
{
    private const TABLE = 'players';

    // Propriétés / Attributs
    /** @var int|null */
    private ?int $id;

    /** @var string */
    private string $name;

    /** @var int */
    private int $score;

    /** @var string */
    private string $team;
        
    /**
     * __construct
     *
     * @param  string $sName
     * @param  string $sTeam
     * @return void
     */
    public function __construct(string $sName, string $sTeam)
    {
        $this->id = null;
        $this->score = 0;
        $this->name = $sName;
        $this->team = $sTeam;
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
    public static function get (int $iId) : ?object
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
        
        $oPlayer = new Player($aData['name'], '');
        $oPlayer->setId($aData['id']);
        $oPlayer->setScore($aData['score']);

        return $oPlayer;
    }
    
    /**
     * @param string $sName
     *
     * @return object
     */
    public static function getByName (string $sName) : ?object
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
        
        $oPlayer = new Player($aData['name'], '');
        $oPlayer->setId($aData['id']);
        $oPlayer->setScore($aData['score']);

        return $oPlayer;
    }

    public function save () : void 
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
    }

    public function delete () : void
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('DELETE FROM players WHERE id = :id');
        $oStmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $oStmt->execute();
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
     * Get the value of team
     */ 
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set the value of team
     *
     * @return  self
     */ 
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

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
}