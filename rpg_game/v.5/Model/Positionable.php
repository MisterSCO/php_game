<?php
namespace Model;

trait Positionable
 {
    /** @var int */
    protected int $x = 0;

    /** @var int */
    protected int $y = 0;

    /**
     * Get the value of x and y
     */ 
    public function getPosition()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }

    /**
     * Set the value of x and y
     *
     * @param int $x
     * @param int $y
     *
     * @return void
     */
    public function setPosition(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;

        return $this;
    }

    /**
     * Get the value of x
     */ 
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set the value of x
     *
     * @return  self
     */ 
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get the value of y
     */ 
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set the value of y
     *
     * @return  self
     */ 
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }
}
?>