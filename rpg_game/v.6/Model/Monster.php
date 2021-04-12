<?php
namespace Model;

abstract class Monster
{
    use Positionable;

    /**@var int */
    public const NB_MONSTERS = null;

    /**@var int */
    public const MAX_HEALTH = null;

    /**@var string */
    public const NAME = 'Monstre';

    /**@var string */
    protected const SYMBOL = 'M';

    /** @var int */
    protected int $health;

    /** @var int */
    protected int $strength;

    /**
     * @return string
     */
    public function __toString() : string
    {
        return static::SYMBOL;
    }

    /**
     * @return int
     */
    public function getRetaliation(): int
    {
        if ($this->isDead()) {
            return 0;
        }

        return (rand(0, 1) ? $this->strength : 0);
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return ($this->health <= 0);
    }

    /**
     * @return array
     */
    public function getMoves(): array
    {
        return [];
    }

    public function getAttackCells(): array
    {
        return $this->getMoves();
    }

    public function hit(\Entity\Character $oCharacter)
    {
        $oCharacter->setHealth($oCharacter->getHealth() - $this->strength);
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
}
