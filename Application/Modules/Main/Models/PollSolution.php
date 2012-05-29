<?php
namespace Application\Modules\Main\Models;

class PollSolution
{
	//cache values so database calls are only made once
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
	 * Constructor for PollSolution object
	 *
	 * @param List<\Application\Entities\Option> $options the options that can be used
	 * @param int $numParticipants total number of participants used to calculate hapiness
	 * @return PollSolution constructed PollSolution with empty maps
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
	 *
	 * @return boolean true if the current solution is invalid
	 */
	public function hasConflicts()
	{
		return !$this->possibleToMakeValidIn(0);
	}

	/**
	 *
	 * @param \Application\Entities\Person $person the person an option should be found for
	 * @return \Application\Entities\Option representing the best option or null if no option is valid
	 */
	public function findBestOption(\Application\Entities\Person $person)
	{
		$curBestOption = null;

		foreach($this->optionsToPeople as $optionId => $values)
		{
			$option = $this->options[$optionId];
			//check if this option is valid and either curBest is still null or this option is of higher preference
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
	 * @param \Application\Entities\Option $option option to be added to
	 * @param \Application\Entities\Person $person person to be added
	 * @return true if the passed person can be added to the passed option to produce a valid result
	 */
	private function OptionIsValid(\Application\Entities\Option $option, \Application\Entities\Person $person)
	{
		$this->addPersonToOption($person, $option);
		$isValid = !$this->hasConflicts();
		$this->removePersonFromOption($person, $option);
		return $isValid;
	}

	/**
	 * Does not guarantee validity, but merley represents the current state of the object.
	 * @return Map<Option, List<Person>> containing the current solutions
	 */
	public function getSolutionMap()
	{
		return $this->optionsToPeople;
	}

	/**
	 * Add a person to the passed option in the PollSolutions map
	 * @param \Application\Entities\Person $person person to be added
	 * @param \Application\Entities\Option $option option to be added to
	 */
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
	/**
	 * Remove a person to the passed option in the PollSolutions map.
	 * @param \Application\Entities\Person $person person to be to
	 * @param \Application\Entities\Option $option option to be removed from
	 */
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

	/**
	 * Get a copy of the list of people not placed
	 * @return List<person> list of people not replace
	 */
	public function getPeopleNotPlaced() {
		return $this->copyArray($this->peopleNotPlaced);
	}

	/**
	 * Get the peorple currently assigned tothe passed option
	 * @param \Application\Entities\Option $option
	 * @return List<Person> list of people assigned to the current option
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
	 * Check if the current solution can be amde valid in a given number of moves
	 * @param int $depth int value representing number of moves
	 * @return boolean true if can be made valid in depth moves
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

	/**
	 * Does not require the solution to be in a valid state
	 * @return Happiness as a percentage for the current solution
	 */
	public function getHappiness()
	{
		return ($this->starValue*100)/($this->totalPeople*$this->maxRating);
	}

	/**
	 * Gebrates a cloned copy of the current solution to be used as a snapshot during recursion
	 * @return PollSolution cloned copy of the current solution
	 */
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

	/**
	 * Copies the current array to allow for cloning
	 * @param array $array to be coppied
	 */
	private function copyArray(array $array) {
		$toReturn = array();
		foreach($array as $element) {
			$toReturn[] = $element;
		}
		return $toReturn;
	}

	/**
	 * Allow to unset values from an array of objects
	 * @param array $array
	 * @param unknown_type $value value to be removed
	 * @param boolean $strict falg for stict lookup
	 */
	private function unsetValue(array $array, $value, $strict = TRUE)
	{
		if(($key = array_search($value, $array, $strict)) !== FALSE) {
			unset($array[$key]);
		}
		return $array;
	}
}
