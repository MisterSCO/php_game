<?php
namespace Model;

/*
 * Référentiel de la classe Wizard
 */
final class Wizard extends Character
{
    /**@var string */
    public const NAME = 'Magicien';

    /**@var string */
    public const SYMBOL = '&#129497;';

    /**@var int */
    public const MIN_HEALTH = 50;

    /**@var int */
    public const MAX_HEALTH = 80;

    /**@var int */
    public const MIN_STRENGTH = 5;

    /**@var int */
    public const MAX_STRENGTH = 10;

    /**@var int */
    public const MIN_MAGIC = 100;

    /**@var int */
    public const MAX_MAGIC = 250;

    // Constantes de classes (accessibles via Wizard::XXX ou self:XXX au sein de la classe)
    // public = accessible en dehors de la classe
    public const FIREBALL_DAMAGE = 60;
    public const FIREBALL_COST = 80;

    // private = non accessible en dehors de la classe
    private const HEAL_DAMAGE = 50;
    private const HEAL_COST = 50;

    /** @var int */
    private int $maxMagic;

    /** @var int */
    private $magic;

    /**
     * @param string $sName
     *
     * @return void
     */
    public function __construct(string $sName)
    {
        parent::__construct($sName);

        $this->health = $this->maxHealth = rand(self::MIN_HEALTH, self::MAX_HEALTH);
        $this->strength = rand(self::MIN_STRENGTH, self::MAX_STRENGTH);
        $this->magic = $this->maxMagic = rand(self::MIN_MAGIC, self::MAX_MAGIC);
    }

    /**
     * Lancement d'un sort d'attaque "Fireball"
     * (le sort en question occasionne 60 dégâts et consomme 80 de mana)
     * @param Character $b
     * 
     * $this = instance appelante (ici l'attaquant "A" - un magicien)
     * $b = instance en paramètre (ici l'attaqué "B")
    */
    function fireball (Character $b) : void
    {
        echo sprintf('(Boule de feu) %s >> %s', $this->getName(), $b->getName()).PHP_EOL;

        // Vérification, est-ce que j'ai du mana ?
        // > Première solution (fonctionnelle mais pas optimale car un ELSE est nécessaire)
        if ($this->getMagic >= Wizard::FIREBALL_COST) {
            $b -> setHealth ( $b->getHealth() - Wizard::FIREBALL_DAMAGE );
            $this->setMagic ( $this->getMagic() - Wizard::FIREBALL_COST );
        } else {
            echo 'Oops.. pas assez de mana'.PHP_EOL;
        }
    }

    /**
     * Lancement d'un sort de soin personnel "Heal"
     * (le sort en question restaure 50 points de vie et consomme 50 de mana)
     * 
     * $this = instance appelante (ici l'attaquant "A" - un magicien)
    */
    function heal() : void
    {
        echo sprintf('(Soin) %s', $this->getName()).PHP_EOL;

        // Vérification, est-ce que j'ai du mana ?
        // > Deuxième solution (= test de sortie)
        if ($this->getMagic < Wizard::FIREBALL_COST) {
            echo 'Oops.. pas assez de mana'.PHP_EOL;
            return;
        }

        $this->setHealth ( $this->getHealth() + self::HEAL_DAMAGE );
        $this->setMagic ( $this->getMagic() - self::HEAL_COST );

        //$this -> health =  $this -> health + 50; (moins propre mais faisable)
        //$this -> magic =  $this -> magic - 50; (moins propre mais faisable)
    }

    /**
     * Get the value of magic
     */ 
    public function getMagic()
    {
        return $this->magic;
    }

    /**
     * Set the value of magic
     *
     * @return  self
     */ 
    public function setMagic($magic)
    {
        $this->magic = $magic;

        return $this;
    }

    /**
     * Get the value of maxMagic
     */ 
    public function getMaxMagic()
    {
        return $this->maxMagic;
    }

    /**
     * Set the value of maxMagic
     *
     * @return  self
     */ 
    public function setMaxMagic($maxMagic)
    {
        $this->maxMagic = $maxMagic;

        return $this;
    }

    public function getMoves(): array
    {
        $aMoves = [];
        
        // Carré
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x, $this->y - 1];

        return $aMoves;
    }

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

        // Diag
        $aMoves[] = [$this->x - 2, $this->y - 2];
        $aMoves[] = [$this->x - 2, $this->y + 2];
        $aMoves[] = [$this->x + 2, $this->y - 2];
        $aMoves[] = [$this->x + 2, $this->y + 2];

        // Carré
        $aMoves[] = [$this->x + 2, $this->y];
        $aMoves[] = [$this->x - 2, $this->y];
        $aMoves[] = [$this->x, $this->y + 2];
        $aMoves[] = [$this->x, $this->y - 2];

        // Diag
        $aMoves[] = [$this->x - 3, $this->y - 3];
        $aMoves[] = [$this->x - 3, $this->y + 3];
        $aMoves[] = [$this->x + 3, $this->y - 3];
        $aMoves[] = [$this->x + 3, $this->y + 3];

        // Carré
        $aMoves[] = [$this->x + 3, $this->y];
        $aMoves[] = [$this->x - 3, $this->y];
        $aMoves[] = [$this->x, $this->y + 3];
        $aMoves[] = [$this->x, $this->y - 3];

        return $aMoves;
    }
}