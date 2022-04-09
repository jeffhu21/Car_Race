<?php


class Car
{
    public $carName; //Each car has its own name

    /* Each car has two types of speeds */
    public $straightSpeed; //Speed on straight
    public $curveSpeed; //Speed on curve

    /*
    const TOTAL_SPEED = 22; //The total speed
    const MIN_SPEED = 4; //The minimum speed of each type, curve and straight
    */
    
    public $totalSpeed = 22; //The total speed
    public $minSpeed = 4; //The minimum speed of each type, curve and straight

    //$straightSpeed = rand($minSpeed,$totalSpeed-$minSpeed);
    
    

}
