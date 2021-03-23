<?php
namespace Model;

/*
 * Référentiel de la classe Wizard
 */
final class Wizard extends Character
{
    /**@var string */
    protected const SYMBOL = '&#129497;';

    // Constantes de classes (accessibles via Wizard::XXX ou self:XXX au sein de la classe)
    // public = accessible en dehors de la classe
    public const FIREBALL_DAMAGE = 60;
    public const FIREBALL_COST = 80;

    // private = non accessible en dehors de la classe
    private const HEAL_DAMAGE = 50;
    private const HEAL_COST = 50;

    /*
     * Propriétés/Attributs
     * Conventions de code : camelCase
     */
    private $magic;

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
}