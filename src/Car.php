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

    
    
    public function __construct(string $carName)
    {
        $totalSpeed = 22; //The total speed

        $minSpeed = 4; //The minimum speed of each type, curve and straight

        $this->carName = $carName;
        $this->straightSpeed = rand($minSpeed,$totalSpeed-$minSpeed);
        $this->curveSpeed = $totalSpeed-$this->straightSpeed;
    }

}
