<?php
include('Car.php');
include('RaceResult.php');

ini_set('max_execution_time', 0); 

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
        $countStraight = 0; //The number of straights multiples of 40
        $countCurve = 0; //The number of curves multiples of 40
        $maxCount = 27;//Straight and curve are approximately 50%
        $seqLength = 50; //2000 elements in total, 50 multiples of 40
        $s = 0;
        $i = 0;

        while ($i < $seqLength) 
        {
            $s = rand(0,1); //The element can be curve or straight. 0 is curve and 1 is straight

            if($s == 1 && $countStraight<$maxCount)
            {
                $this->seq[$i] = $s;
                $countStraight++;
                $i++;
            }
            else if($s == 0 && $countCurve<$maxCount)
            {
                $this->seq[$i] = $s;
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
        $carLength = 5; //5 cars in total
        $newCar = null; 
        $i = 0;
        $sameCar = false; //Check whether the cars have the same speed

        while ($i < $carLength) 
        {            
            $newCar = new Car('Car '.strval($i+1));

            //Make sure cars with different speed
            for ($j=0; $j < $i; $j++) 
            { 
                //Terminate the loop once found a car with same speed
                if($this->cars[$j]->straightSpeed == $newCar->straightSpeed)
                {
                    $sameCar = true;
                    break;
                }
                
            }

            //Add car with different speed
            if(!$sameCar)
            {
                $this->cars[$i] = $newCar;
                $i++;
            }
        } 
    }
    

    public function runRace(): RaceResult
    {
        /* Create track and cars before the race */
        $this->createTrack();
        $this->createCars();

        //echo memory_get_usage() . "\n";

        $raceResult = new RaceResult($this->seq,$this->cars);

        unset($this->seq);
        unset($this->cars);

        return $raceResult;
    }

}
