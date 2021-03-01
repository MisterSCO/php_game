<?php
namespace Entity;

use Manager\DbManager;

/**
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class Player implements \Manager\DbManagerInterface
{
    // Propriétés / Attributs
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
    public static function get(int $iId): object
    {
        return new Player('TODO','TODO');
    }
    public function save(object $oObject): void
    {

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
}