<?php
namespace Application\Modules\Main\Models;
     
class PollSolution
{
    private $maxRating;
    private $totalPeople;
	private $starValue;
    private $numPossiblePeople;
    private $totalOverMax;
    
	// Map<Option, List<Person>>
	private $optionsToPeople;
    
    // List<Person>
    private $peopleNotPlaced;

	/**
	 * put your comment there...
	 *
	 * @param List<\Application\Entities\Option> $options
	 * @param int $numParticipants
	 * @return PollSolution
	 */
	public function __construct(\Spot\Entity\Collection $options, $numParticipants, $maxRating) {
        $this->maxRating = intval($maxRating);
        
        $this->peopleNotPlaced = array();
        $this->numPossiblePeople = 0;
        $this->totalOverMax = 0;
        $this->optionsToPeople = array(); //new HashMap<Option, List<Person>>();
        $this->starValue = 0;
                  
		foreach($options as $option) {
            $this->numPossiblePeople += $option->maxSize == null ? PHP_INT_MAX : $option->maxSize;
			$this->optionsToPeople[$option->id] = array();
		}
        $this->totalPeople = $numParticipants;
	}

	/**
	 * returns boolean
	 */
	public function hasConflicts()
	{
		return !$this->possibleToMakeValidIn(0);
	}

	/**
	 * returns \Application\Entities\Option
	 *
	 */
	public function findBestOption(\Application\Entities\Person $person)
	{
		$mapper = $GLOBALS["registry"]->mapper;

		$curBestOption = null;

        
		foreach($this->optionsToPeople as $optionId => $values)
		{                                              
            $option = $mapper->first('\Application\Entities\Option', array('id' => $optionId));
            die("opt: ".$optionId.", per: ".$person->id);
            //die(var_dump($option));
            die(var_dump($mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $optionId))));
			if($this->OptionIsValid($option, $person)
                && ($curBestOption == null
                        || $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id))->priority > $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $curBestOption->id))->priority
                        || ($mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id))->priority == $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $curBestOption->id))->priority
                                && ($curBestOption->maxSize == null ? PHP_INT_MAX : $curBestOption->maxSize) - count($this->optionsToPeople[$curBestOption->id]) > ($options->maxSize == null ? PHP_INT_MAX : $option->maxSize) - count($this->optionsToPeople[$options->id]))))
            {
                $curBestOption = $option;  
            }
		}
        
		return $curBestOption;
	}
	/**
	 *
	 */
	private function OptionIsValid(\Application\Entities\Option $option, \Application\Entities\Person $person)
	{
		$this->addPersonToOption($person, $option);
		$isValid = !$this->hasConflicts();
		$this->removePersonFromOption($person, $option);
		return $isValid;

	}

	/**
	 * returns Map<Option, List<Person>>
	 */
	public function getSolutionMap()
	{
		return $this->optionsToPeople;
	}

	public function addPersonToOption(\Application\Entities\Person $person, \Application\Entities\Option $option = null)
	{    
        if ($option == null) {
            $this->peopleNotPlaced[] = $person;
        }
        else
        {
            $mapper = $GLOBALS["registry"]->mapper;
            
		    // Add person to the map with option as key
		    $this->optionsToPeople[$option->id][] = $person;
               
		    $optionValue = $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id));
		     
		    $this->starValue += $optionValue;

		    if (count($this->optionsToPeople[$option->id]) > $option->maxSize == null ? PHP_INT_MAX : $option->maxSize){
			    $this->totalOverMax++;
		    }
        }
	}

	public function removePersonFromOption(\Application\Entities\Person $person, \Application\Entities\Option $option = null)
	{
        if ($option == null) {
            $this->unsetValue($this->peopleNotPlaced, $person);
        }
        else
        {
            $mapper = $GLOBALS["registry"]->mapper;
            
            //die(var_dump(in_array($person, $this->optionsToPeople[$option->id])));
            // Remove person to the map with option as key
            $optionArray = $this->optionsToPeople[$option->id];
            
            $this->unsetValue($optionArray, $person);
               
            $optionValue = $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id));
             
            $this->starValue -= $optionValue;

            if (count($this->optionsToPeople[$option->id]) >= $option->maxSize == null ? PHP_INT_MAX : $option->maxSize){
                $this->totalOverMax--;
            }
        }
	}
    
    public function getPeopleNotPlaced() {
        return clone $this->peopleNotPlaced;
    }

	/**
	 * returns array of Person
	 */
	public function getPeopleForOption(\Application\Entities\Option $option = null)
	{
        if (!$option)
        {
            return unserialize(serialize($this->peopleNotPlaced));
        }
		return unserialize(serialize($this->optionsToPeople[$option->id]));
	}

	public function getStarValue()
	{
		return $this->starValue;
	}

	/**
	 * $depth is int
	 * returns boolean
	 */
	public function possibleToMakeValidIn($depth)
	{
		$totalShifts = $this->totalOverMax;
		if ($this->numPossiblePeople > 0)
		{
			$totalShifts += min($this->numPossiblePeople, count($this->peopleNotPlaced));
		}
		return $totalShifts <= $depth;
	}
   
    public function getHappiness()
    {     
       return ($this->starValue*100)/($this->totalPeople*$this->maxRating);
    }

	public function __clone()
	{
		// This may not work
		return unserialize(serialize($this));
	}
    
    private function unsetValue(array $array, $value, $strict = TRUE)
    {
        if(($key = array_search($value, $array, $strict)) !== FALSE) {
            unset($array[$key]);
        }
        return $array;
    }
}
