<?php


class Car
{
    /**
     * @var string
     */
    public $carName; //Each car has its own name

    /* Each car has two types of speeds */
    /**
     * @var int
     */
    public $straightSpeed; //Speed on straight
    /**
     * @var int
     */
    public $curveSpeed; //Speed on curve

    public $totalSpeed = 22; //The total speed

    public $minSpeed = 4; //The minimum speed of each type, curve and straight
    
    public function __construct(string $carName)
    {
        $this->carName = $carName;
        $this->straightSpeed = rand($this->minSpeed,$this->totalSpeed-$this->minSpeed);
        $this->curveSpeed = $this->totalSpeed-$this->straightSpeed;
    }

}
