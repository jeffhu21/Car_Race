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

    public function __construct(array $seq, array $cars)
    {
        $this->seq = $seq;
        $this->cars = $cars;
    }

    public function getNextCarPositions($currentCarPos): array
    {
        $nextCarPos = array(); //Next position of cars
        $currentSeqIndex = 0; //Current Sequence Index
        $nextSeqIndex = 0; //Next Sequence Index
        $currentSpeed = 0;

        foreach ($this->cars as $car) 
        {
            $currentSeqIndex=intval(($currentCarPos[$car->carName])/40);

            if($this->seq[$currentSeqIndex] == 1)
            {
                $currentSpeed = $car->straightSpeed;
            }
            else
            {
                $currentSpeed = $car->curveSpeed;
            }

            $nextSeqIndex = intval((($currentCarPos[$car->carName])+$currentSpeed)/40);

            if($this->seq[$currentSeqIndex] == $this->seq[$nextSeqIndex])
            {
                $nextCarPos[$car->carName] = intval(($currentCarPos[$car->carName])+$currentSpeed);
            }
            else
            {
                $nextCarPos[$car->carName] = intval(40*($this->seq[$nextSeqIndex]));
            }
        }

        return $nextCarPos;

    }

    public function getRoundResults(): array
    {
        //echo memory_get_usage() . "\n";
        //print_r('Manny');
        $round = 0; //Define a round
        $carPos = array(); //Define cars' position array[carName=>position]
        $nextCarPos = array(); //Next position of cars
        $countWin = 0;
        
        /* Initialize position of each car */
        foreach ($this->cars as $car) 
        {
            $carPos[$car->carName] = 0;
        }

        $roundResult = new RoundResult($round,$carPos); //For Round 0
        array_push($this->roundResults,$roundResult);

        while($countWin == 0)
        {
            $nextCarPos=$this->getNextCarPositions($carPos);
            unset($carPos);
            $carPos = $nextCarPos;
            unset($nextCarPos);
            $round++;

            //Check whether there is any cars cross the finish line
            foreach ($carPos as $name => $pos) 
            {
                if($pos >= 2000)
                {
                    $countWin++;
                }
            }
            unset($roundResult);
            $roundResult = new RoundResult($round,$carPos); //For next round
            array_push($this->roundResults,$roundResult);
            
        }

        if($countWin > 1)
        {
            //Print Draw
            print_r('DRAW!');
        }
        else
        {
            //Print Win
            print_r('WIN!');
        }
        //Print Result

        return $this->roundResults;
    }
}
