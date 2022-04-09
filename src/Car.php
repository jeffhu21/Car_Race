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
    
    public function __construct(string $carName, int $straightSpeed)
    {
        $totalSpeed = 22; //The total speed
        $this->carName = $carName;
        $this->straightSpeed = $straightSpeed;
        $this->curveSpeed = $totalSpeed-$this->straightSpeed;
    }

}
