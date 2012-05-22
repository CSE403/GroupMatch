<?php
namespace Application\Modules\Main\Models;
     
class PollSolution
{
	private $starValue;
	private $maxPerOption;
	private $numRequiredAtLargeSize;
	private $numOptionsAtMax;
	private $totalOverMax;

	// Map<Option, List<Person>>
	private $optionsToPeople;

	/**
	 * put your comment there...
	 *
	 * @param List<\Application\Entities\Option> $options
	 * @param int $numParticipants
	 * @return PollSolution
	 */
	public function __construct(\Spot\Entity\Collection $options, $numParticipants) {
        $numParticipants = intval($numParticipants);
        
		$this->numOptionsAtMax = 0;
		$this->totalOverMax = 0;
		$this->optionsToPeople = array(); //new HashMap<Option, List<Person>>();
		$this->starValue = 0;
		$this->numRequiredAtLargeSize = $numParticipants % count($options);
		$this->maxPerOption = $numParticipants / count($options) + 1;
                  
		foreach($options as $option) {
			$optionsToPeople[$option] = array();
		}
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

		foreach($this->optionsToPeople as $option)
		{
			if($this->OptionIsValid($option, $person)){
				if ($curBestOption == null) {
					$curBestOption = $option;
				}
				else
				{
					$betterOptionValue = $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id));
					$curBestOptionValue = $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $curBestOption->id));
					$isBetterOption = $betterOptionValue->priority > $person;
					$numPeopleAtBetter = count($optionsToPeople[$option]);
					$numPeopleAtCurBest = count($optionsToPeople[$curBestOption]);

					if ($betterOptionValue > $curBestOptionValue
							|| ($betterOptionValue == $curBestOptionValue
									&& $numPeopleAtBetter > $numPeopleAtCurBest)
					)
					{
						$curBestOption = $option;
					}
				}
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
		$this->removePersonFromOption(person, option);
		return $isValid;

	}

	/**
	 * returns Map<Option, List<Person>>
	 */
	public function getSolutionMap()
	{
		return $this->optionsToPeople;
	}

	public function addPersonToOption(\Application\Entities\Person $person, \Application\Entities\Option $option)
	{
        
		$mapper = $GLOBALS["registry"]->mapper;

		// Add person to the map with option as key
		$this->optionsToPeople[$option][] = $person;
           
		$optionValue = $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id));
		 
		$this->starValue += $optionValue;
      
		if (count($this->optionsToPeople[$option]) == $this->maxPerOption){
			$this->numOptionsAtMax++;
		}
		elseif (count($this->optionsToPeople[$option]) > $this->maxPerOption){
			$this->totalOverMax++;
		}
	}

	public function removePersonFromOption(\Application\Entities\Person $person, \Application\Entities\Option $option)
	{
		$mapper = $GLOBALS["registry"]->mapper;

		// Remove person to the map with option as key
		unset($this->optionsToPeople[$option][$person]);

		$optionValue = $mapper->first('\Application\Entities\Answer', array('personId' => $person->id, 'optionId' => $option->id));
		 
		$this->starValue -= $optionValue;

		if (count($this->optionsToPeople[$option]) == $this->maxPerOption-1){
			$this->numOptionsAtMax--;
		}
		elseif (count($this->optionsToPeople[$option]) >= $this->maxPerOption){
			$this->totalOverMax--;
		}
	}

	/**
	 * returns array of Person
	 */
	public function getPeopleForOption(\Application\Entities\Option $option)
	{
		return clone $this->optionsToPeople[$option];
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
		if ($this->numOptionsAtMax > $this->numRequiredAtLargeSize)
		{
			$totalShifts += $this->numOptionsAtMax - $this->numRequiredAtLargeSize;
		}
		return $totalShifts <= $depth;
	}

	public function __clone()
	{
		// This may not work
		return unserialize(serialize($this));
	}
}
