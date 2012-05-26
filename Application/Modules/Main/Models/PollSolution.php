<?php
namespace Application\Modules\Main\Models;
     
class PollSolution
{
    public $answers;
    private $options;
    
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
        
        // Caching
        $this->answers = array();
        $this->options = array();
        
        foreach($options as $option) {
            $this->options[$option->id] = $option;
            foreach($option->answers as $answer) {
                $this->answers[$answer->optionId.",".$answer->personId] = $answer;
            }
        }
        
        $this->maxRating = intval($maxRating);
        
        $this->peopleNotPlaced = array();
        $this->numPossiblePeople = 0;
        $this->totalOverMax = 0;
        $this->optionsToPeople = array(); //new HashMap<Option, List<Person>>();
        $this->starValue = 0;
                  
		foreach($options as $option) {
            $this->numPossiblePeople += $option->maxSize;
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
    	$curBestOption = null;
                              
		foreach($this->optionsToPeople as $optionId => $values)
		{                                              
            $option = $this->options[$optionId];
            //die("opt: ".$optionId.", per: ".$person->id);
            //die(var_dump($option));
            //die(var_dump($mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $optionId))));
			if($this->OptionIsValid($option, $person)
                && ($curBestOption == null
                        || $this->answers[$option->id.",".$person->id]->priority > $this->answers[$curBestOption->id.",".$person->id]->priority
                        || ($this->answers[$option->id.",".$person->id]->priority == $this->answers[$curBestOption->id.",".$person->id]->priority
                                && ($curBestOption->maxSize) - count($this->optionsToPeople[$curBestOption->id]) > ($option->maxSize) - count($this->optionsToPeople[$option->id]))))
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
		    // Add person to the map with option as key
		    $this->optionsToPeople[$option->id][] = $person;
               
		    $optionValue = $this->answers[$option->id.",".$person->id];

		    $this->starValue += $optionValue->priority;
            $this->numPossiblePeople--;
		    if (count($this->optionsToPeople[$option->id]) > $option->maxSize){
                $this->totalOverMax++;
		    }
        }
	}

	public function removePersonFromOption(\Application\Entities\Person $person, \Application\Entities\Option $option = null)
	{
        if ($option == null) {
            $this->peopleNotPlaced = $this->unsetValue($this->peopleNotPlaced, $person);
        }
        else
        {
            //die(var_dump(in_array($person, $this->optionsToPeople[$option->id])));
            // Remove person to the map with option as key
            //$optionArray = ;
            
            $this->optionsToPeople[$option->id] = $this->unsetValue($this->optionsToPeople[$option->id], $person);
               
            $optionValue = $this->answers[$option->id.",".$person->id];
             
            $this->starValue -= $optionValue->priority;
            $this->numPossiblePeople++;
            if (count($this->optionsToPeople[$option->id]) >= $option->maxSize){
                $this->totalOverMax--;
            }
        }
	}
    
    public function getPeopleNotPlaced() {
        return $this->copyArray($this->peopleNotPlaced);
    }

	/**
	 * returns array of Person
	 */
	public function getPeopleForOption(\Application\Entities\Option $option = null)
	{
        if (!$option)
        {
            return $this->copyArray($this->peopleNotPlaced);
        }
        
		return $this->copyArray($this->optionsToPeople[$option->id]);
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
		//return unserialize(serialize($this));
        
        $collection = new \Spot\Entity\Collection();
        $toReturn = new PollSolution($collection, 0, 0);
        
        $toReturn->answers &= $this->answers;
        $toReturn->options &= $this->options;
        
        $toReturn->maxRating = $this->maxRating;
        $toReturn->totalPeople = $this->totalPeople;
        $toReturn->starValue = $this->starValue;
        $toReturn->numPossiblePeople = $this->numPossiblePeople;
        $toReturn->totalOverMax = $this->totalOverMax;
        
        $temp = array();
        foreach($this->optionsToPeople as $id => $people){
            $temp[$id] = $this->copyArray($people);
        }
        $toReturn->optionsToPeople = $temp;
    
        $toReturn->peopleNotPlaced = $this->copyArray($this->peopleNotPlaced);
        
        return $toReturn;
	}
    
    private function copyArray(array $array) {
        $toReturn = array();
        foreach($array as $element) {
            $toReturn[] = $element;
        }
        return $toReturn;
    }
    
    private function unsetValue(array $array, $value, $strict = TRUE)
    {
        if(($key = array_search($value, $array, $strict)) !== FALSE) {
            unset($array[$key]);
        }
        return $array;
    }
}
