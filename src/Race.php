<?php
include('Car.php');

class Race
{

    /**
     * @var array of track
     */
    public $seq = array(); 

    /**
     * @var array of cars
     */
    public $cars = array(); 

    /**
         * Create a track
    */
    public function createTrack()
    {
        $countStraight = 0; //The number of straights
        $countCurve = 0; //The number of curves
        $maxCount = 27;//Straight and curve are approximately 50%
        $seqLength = 50; //2000 elements in total, 50 multiples of 40
        $s = 0;
        $i = 0;

        while ($i < $seqLength) 
        {
            $s = rand(0,1);

            if($s == 1 && $countStraight<$maxCount)
            {
                $seq[$i] = $s;
                $countStraight++;
                $i++;
            }
            else if($s == 0 && $countCurve<$maxCount)
            {
                $seq[$i] = $s;
                $countCurve++;
                $i++;
            }

        }
        
    }

    /**
         * Create cars
    */
    public function createCars()
    {
        $totalSpeed = 22;
        $minSpeed = 4; //The minimum speed of each type, curve and straight
        $carLength = 5; //5 cars in total

        for ($i=0; $i < $carLength; $i++) 
        { 
            $cars[$i] = new Car('Car '.strval($i+1),rand($minSpeed,$totalSpeed-$minSpeed));
        }
        
    }
    

    public function runRace(): RaceResult
    {
        return null;
    }

}
