<?php
namespace Entity;

use Manager\DbManager;
use PDO;

/**
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class Player implements \Manager\DbManagerInterface
{
    // Propriétés / Attributs

    /** @var int|null */
    private ?int $id;

    /** @var string */
    private string $name;

    /** @var string */
    private string $team;

    /** @var int */
    private int $score;
        
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

    public static function loadAll(): array
    {

        $oPDO = DbManager::getDb();

        $query = $oPDO->prepare('
            SELECT 
                id,
                name,
                score
            FROM `players` 
            ORDER BY score DESC
        ');
        $query->execute();

        $aPlayer=[];
        while ($aData = $query->fetch()) {
            $oPlayer = new Player($aData['name'], '');
            $oPlayer->setScore($aData['score']);

            $aPlayer[]=$oPlayer; 
        }
        return $aPlayer;
    }
    public static function get(int $iId): ?object
    {
        $oPDO = DbManager::getDb();

        $query = $oPDO->prepare('
            SELECT 
                id,
                name,
                score
            FROM `players` 
            WHERE id = :id
        ');
        $query->bindValue(':id', $iId, \PDO::PARAM_INT);
        $query->execute();

        $aData = $query->fetch();


        if (!$aData) {
            return null;
        }

        $oPlayer = new Player($aData['name'], '');
        $oPlayer->setId($aData['id']);
        $oPlayer->setScore($aData['score']);

        return $oPlayer;
    }

    public static function getByName(string $sName): ?object
    {

        $oPDO = DbManager::getDb();

        $query = $oPDO->prepare('
            SELECT 
                id,
                name,
                score
            FROM `players` 
            WHERE name = :name
        ');
        $query->bindValue(':name', $sName, \PDO::PARAM_STR);
        $query->execute();

        $aData = $query->fetch();
        

        if (!$aData) {
            return null;
        }

        $oPlayer = new Player($aData['name'], '');
        $oPlayer->setId($aData['id']);
        $oPlayer->setScore($aData['score']);

        return $oPlayer;
    }

    public function save(): void
    {
        $oPDO = DbManager::getDb();

        if ($this->getId()) {
            
            $query = $oPDO->prepare('
                UPDATE `players` SET `score`= :score
                WHERE id = :id
            ');
            $query->bindValue(':score', $this->getScore(), \PDO::PARAM_INT);
            $query->bindValue(':id', $this->getId(), \PDO::PARAM_INT);

            $query->execute();
        }
        else {
            $query = $oPDO->prepare('
                INSERT INTO `players`(`name`, `score`) VALUES (:name,:score)
            ');
            $query->bindValue(':name', $this->getName(), \PDO::PARAM_STR);
            $query->bindValue(':score', $this->getScore(), \PDO::PARAM_INT);
            
            $query->execute();
            
            $this->setId($oPDO->lastInsertId());
        }

        
        
        
        return ;
    }


    public function delete(object $oObject): void
    {

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