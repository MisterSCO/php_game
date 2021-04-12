<?php
namespace Entity;

use Manager\DbManager;
use Manager\DbManagerInterface;
use Model\Monster;
use Model\Pawn;

/**
 * Référentiel de la classe Character
 * Conventions de code : PascalCase
 * abstract = non instanciable (non obligatoire)
 */
abstract class Character extends Pawn implements DbManagerInterface
{
    /** @var string */
    private const TABLE = 'characters';

    /** @var string */
    public const NAME = 'Personnage';

    /** @var int|null */
    protected ?int $id;

    /** @var string */
    protected string $name;

    /** @var int */
    protected int $maxHealth;

    /** @var int */
    protected int $health;

    /** @var int */
    protected int $strength;

    /**
     * @param string $sName
     *
     * @return void
     */
    public function __construct(string $sName)
    {
        parent::__construct();

        $this->name = $sName;
    }

    /**
     * @return array
     */
    public function getMoves(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAttacks(): array
    {
        $aMoves = [];

        // Diag
        $aMoves[] = [$this->x - 1, $this->y - 1];
        $aMoves[] = [$this->x - 1, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y - 1];
        $aMoves[] = [$this->x + 1, $this->y + 1];

        // Carré
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x, $this->y - 1];

        return $aMoves;
    }

    /**
     * @param Monster $oMonster
     *
     * @return bool
     */
    public function hit(Monster $oMonster): bool
    {
        if ($this->isDead()) {
            return false;
        }

        $oMonster->setHealth($oMonster->getHealth() - $this->strength);

        // Riposte du monstre
        $this->health -= $oMonster->getRetaliation();

        return true;
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->health <= 0;
    }

    /**
     * @return array
     */
    public static function loadAll() : array
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('SELECT character_info FROM `'. self::TABLE .'`');
        $oStmt->execute();

        // On récupère toutes les lignes
        $aCharacters = [];
        while ($aData = $oStmt->fetch()) {
            $aCharacters[] = unserialize($aData['character_info']);
        }

        return $aCharacters;
    }

    /**
     * @param Player $oPlayer
     *
     * @return array
     */
    public static function loadAllByPlayer(Player $oPlayer) : array
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('SELECT character_info FROM `'. self::TABLE .'` WHERE player_id = :player_id');
        $oStmt->bindValue(':player_id', $oPlayer->getId(), \PDO::PARAM_INT);
        $oStmt->execute();

        // On récupère toutes les lignes
        $aCharacters = [];
        while ($aData = $oStmt->fetch()) {
            $aCharacters[] = unserialize($aData['character_info']);
        }

        return $aCharacters;
    }

    /**
     * @param int $iId
     *
     * @return object
     */
    public static function get(int $iId) : ?object
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('SELECT character_info FROM `'. self::TABLE .'` WHERE id = :id');
        $oStmt->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oStmt->execute();

        // On récupère la première ligne
        $aData = $oStmt->fetch();
        if (!$aData) {
            // Condition de sortie : aucun utilisateur valide
            return null;
        }

        return unserialize($aData['character_info']);
    }

    public function save() : void
    {
        $oPdo = DbManager::getDb();

        // Est-ce que mon Character existe en base ?
        if ($this->getId()) {
            // >> Si oui : UPDATE (> score)
            $oStmt = $oPdo->prepare('UPDATE `'. self::TABLE .'` SET pos_x = :pos_x, pos_y = :pos_y, character_info = :character_info WHERE id = :id');
            $oStmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $oStmt->bindValue(':pos_x', $this->x, \PDO::PARAM_INT);
            $oStmt->bindValue(':pos_y', $this->y, \PDO::PARAM_INT);
            $oStmt->bindValue(':character_info', serialize($this), \PDO::PARAM_STR);
            $oStmt->execute();
        } else {
            // >> Si non : INSERT INTO (> name, score)
            $oStmt = $oPdo->prepare('INSERT INTO `'. self::TABLE .'` ( player_id, name, pos_x, pos_y, character_info ) VALUES (:player_id, :name, :pos_x, :pos_y, :character_info)');
            $oStmt->bindValue(':player_id', $this->player->getId(), \PDO::PARAM_INT);
            $oStmt->bindValue(':name', $this->name, \PDO::PARAM_STR);
            $oStmt->bindValue(':pos_x', $this->x, \PDO::PARAM_INT);
            $oStmt->bindValue(':pos_y', $this->y, \PDO::PARAM_INT);
            $oStmt->bindValue(':character_info', serialize($this), \PDO::PARAM_STR);
            $oStmt->execute();

            // On stocke l'id AUTO_INCREMENT
            $this->setId($oPdo->lastInsertId());

            $this->save();  // resave with id
        }
    }

    public function delete() : void
    {
        $oPdo = DbManager::getDb();

        $oStmt = $oPdo->prepare('DELETE FROM `'. self::TABLE .'` WHERE id = :id');
        $oStmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $oStmt->execute();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return Character
     */
    public function setId(?int $id): Character
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get /*
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set /*
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of health
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set the value of health
     *
     * @return  self
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get the value of strength
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set the value of strength
     *
     * @return  self
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get the value of maxHealth
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * Set the value of maxHealth
     *
     * @return  self
     */
    public function setMaxHealth($maxHealth)
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }
}
