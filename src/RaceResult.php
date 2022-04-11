<?php
include('RoundResult.php');

ini_set('memory_limit', '1024M');

class RaceResult
{
    /**
     * @var array of StepResult
     */
    private $roundResults = [];

    /**
     * @var array of track
     */
    public $seq = array(); 

    /**
     * @var array of cars
     */
    public $cars = array(); 

    public $len = 40; //Length of each sequence of track

    public function __construct(array $seq, array $cars)
    {
        $this->seq = $seq;
        $this->cars = $cars;
    }

    /**
         * Calculate next positions for each car
         * @param $currentCarPos - current position for each car
         * @return $nextCarPos - next positions for each car
    */
    public function getNextCarPositions($currentCarPos): array
    {
        $nextCarPos = array(); //Associative Array. Next position of cars
        $currentSeqIndex = 0; //Current Sequence Index
        $nextSeqIndex = 0; //Next Sequence Index
        $currentSpeed = 0; //Current speed

        foreach ($this->cars as $car) 
        {

            $currentSeqIndex=intval(($currentCarPos[$car->carName])/($this->len));

            if($this->seq[$currentSeqIndex] == 1)
            {
                $currentSpeed = $car->straightSpeed;
            }
            else
            {
                $currentSpeed = $car->curveSpeed;
            }

            $nextSeqIndex = intval((($currentCarPos[$car->carName])+$currentSpeed)/($this->len));

            //Check whether the car crosses the finish line
            if($nextSeqIndex < count($this->seq))
            {
                if($this->seq[$currentSeqIndex] == $this->seq[$nextSeqIndex])
                {
                    $nextCarPos[$car->carName] = intval(($currentCarPos[$car->carName])+$currentSpeed);
                }
                else
                {
                    $nextCarPos[$car->carName] = intval(($this->len)*($nextSeqIndex));
                }
            }
            else
            {
                $nextCarPos[$car->carName] = count($this->seq)*($this->len);// $nextCarPos[$car->carName] = 2000
                //$nextCarPos[$car->carName] = intval(($currentCarPos[$car->carName])+$currentSpeed);
            }
            
        }

        return $nextCarPos;

    }

    /**
        * Calculate the last dash time
        * @param $pos - position before car crossing the finish line
        * @param $carName - name of car crossing the finish line
        * @return $time - the last dash time
     */
    public function timeTaken($pos,$carName)
    {
        $time = 0.0;
        $currentSpeed = 0;

        //Find the car crossing the finish line and get the current speed
        foreach ($this->cars as $car) 
        {
            if($carName == $car->carName)
            {
                if($this->seq[count($this->seq)-1] == 1)
                {
                    $currentSpeed = $car->straightSpeed;
                }
                else
                {
                    $currentSpeed = $car->curveSpeed;
                }
                break;
            }
        }

        //Calculate the last dash time 
        if($currentSpeed != 0)
        {
            $time = number_format((count($this->seq)*($this->len)-$pos)/$currentSpeed,2);
        }

        //echo('TIME = '.$time."\n");

        return $time;
    }

    public function getRoundResults(): array
    {
        $round = 0; //Define a round
        $carPos = array(); //Define cars' position, associative array[carName=>position]
        $nextCarPos = array(); //Next position of cars
        $countFinished = 0; //Count how many cars cross the finish line
        $tempTime = 0.0;
        $timeTaken = array(); //Collect the last dash time
        $minTime = 0.0;
        $countMinTime = 0;

        /* Initialize position of each car */
        foreach ($this->cars as $car) 
        {
            $carPos[$car->carName] = 0;
        }

        $roundResult = new RoundResult($round,$carPos); //For Round 0
        array_push($this->roundResults,$roundResult);

        //Start race
        while($countFinished == 0)
        {
            $nextCarPos=$this->getNextCarPositions($carPos);
            $round++;

            //Check whether there is any cars cross the finish line
            foreach ($nextCarPos as $name => $pos) 
            {
                if($pos >= count($this->seq)*($this->len))//$pos >= 2000
                {
                    
                    $tempTime = $this->timeTaken($carPos[$name],$name);

                    //$timeTaken[$countFinished] = $tempTime;
                    $timeTaken[$name] = $tempTime;
                    
                    $countFinished++;
                }
            }

            unset($carPos);
            $carPos = $nextCarPos;
            unset($nextCarPos);

            unset($roundResult);
            $roundResult = new RoundResult($round,$carPos); //For next round
            array_push($this->roundResults,$roundResult);

        }

        //Determine the game result is win or draw
        if($countFinished > 1)
        {
            $minTime = min($timeTaken);

            //Check whether there is any cars crossing the finish line at the same time
            foreach ($timeTaken as $name => $time) 
            {
                if($time == $minTime)
                {
                    print_r($name.", ");
                    $countMinTime++;
                }
            }
            

            /*
            for ($i=0; $i < count($timeTaken); $i++) 
            { 
                if($timeTaken[$i] == $minTime)
                {
                    $countMinTime++;
                }
            }
            */
            
            
            if($countMinTime == 1)
            {
                print_r('WIN!<br>'); //Print Win Result
            }
            else
            {
                print_r('DRAW!<br>'); //Print Draw Result
            }
            
            
        }
        elseif($countFinished == 1)
        {
            print_r(key($timeTaken).' WIN!<br>'); //Print Win Result
        }

        return $this->roundResults;
    }
}
