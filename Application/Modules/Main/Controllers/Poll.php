<?php       
namespace Application\Modules\Main\Controllers;
/**
 The poll controller houses all the logic needed for displaying the polls, as well as generating the
 "best answer" based on the current poll entries.
 */
class Poll extends \Saros\Application\Controller
{
	/**
	 Initializes the poll page.
	 @ZFR: Doesn't initialize anything. The data is hard coded.
	 */
	public function init() {

	}

	/**
	 Redirected the user to his/her poll page
	 */
	public function indexAction($pollId)
	{
		$this->view->headStyles()->addStyle("poll");
        $this->view->topBar()->setPage("poll");
        
        $poll = $this->registry->mapper->first('\Application\Entities\Poll', array('id' => $pollId));
        
        $this->view->Poll = $poll;
	}

	/**
	 Append unique view style
	 */
	public function participateAction($pollId) {
		$this->view->headStyles()->addStyle("participate");
        $this->view->topBar()->setPage("participate");
	}
	
	/**
	 On the user's poll page, there is a link to generate the current answer. This function
	 generates that answer, and then displays it on the same page as the "Happiness meter".
	 */
	public function solutionAction($pollId)
	{
		$this->view->headStyles()->addStyle("solution");
        $this->view->topBar()->setPage("solution");
		
		// Verify that this exists
		/*$pollId = intval($pollId);

		$mapper = $this->registry->mapper;

		$people = $mapper->all('\Application\Entities\Person', array('pollId' => $pollId));
		$options = $mapper->all('\Application\Entities\Option', array('pollId' => $pollId));

		$pollSolution = new \Application\Modules\Main\Models\PollSolution($options, count($people));

		foreach($people as $person) {
			$option = $pollSolution->findBestOption($person);
			$pollSolution->addPersonToOption($person, $option);
		}

		$curBestSolution = null;
		for ($i = 1; $i <= 4; $i++)
		{
			$curBestSolution = null;
			while ($curBestSolution == null
					|| $curBestSolution->getStarValue() < $pollSolution
					->getStarValue())
			{
				$curBestSolution = $pollSolution->clone();
				$pollSolution = move(pollSolution, i, options);
			}
		}


		// Hand it off to the view
		$this->view->Solution = $curBestSolution;
		*/
	}

	/**
	 Private method used by the solution solver, which finds the order of people that generates the
	 most "happiness", but by moving people from group to group $deptch times.
	 return \Application\Modules\Main\Models\PollSolution
	 */
	private function move(\Application\Modules\Main\Models\PollSolution $pollSolution, $depth, $options) {
		// PollSolutions we are working with
		$toReturn = null;
		$curBest = null;

		if ($depth == 0 && !$pollSolution->hasConflicts()){
			return clone $pollSolution;
		}

		if($depth == 0){
			return toReturn;
		}

		foreach($options as $option) {
			foreach($pollSolution->getPeopleForOption($option) as $person) {
				$pollSolution->removePersonFromOption($person, $option);

				foreach($options as $optionAdd) {
					$pollSolution->addPersonToOption($person, $optionAdd);
					if ($pollSolution->possibleToMakeValidIn($depth-1)){
						$curBest = $this->move($pollSolution, $depth-1, $options);
						if ($toReturn == null
								|| ($curBest != null && $curBest->getStarValue() > $toReturn->getStarValue())) {
							$toReturn = $curBest;
						}
					}
					 
					$pollSolution->removePersonToOption($person, $optionAdd);
				}

				$pollSolution->addPersonFromOption($person, $option);
			}
		}

		return $toReturn;
	}
}
