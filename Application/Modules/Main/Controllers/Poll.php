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
    
    // Gets a poll ID given a guid
	// redirects if invalid guid
    private function getPollId($guid) {
        $poll = $this->registry->mapper->first('\Application\Entities\Poll', array('guid' => $guid));
		if(empty($poll)) {
			$homePage = $GLOBALS["registry"]->utils->makeLink("Index", "index");
			$this->redirect($homePage);
		}
        return $poll->id;
    }

	/**
	 Redirected the user to his/her poll page
	 */
	public function indexAction($guid=null)
	{
		$this->view->headStyles()->addStyle("poll");
		$this->view->headStyles()->addStyle("colorbox");
		$this->view->headScripts()->addScript("jquery_colorbox-min");
        $this->view->topBar()->setPage("poll");
        
        $pollId = $this->getPollId($guid);
        $poll = $this->registry->mapper->first('\Application\Entities\Poll', array('id' => $pollId));
        
		$this->view->isOwner = $this->isOwner($pollId);
        $this->view->Poll = $poll;
	}

	/**
	 Append unique view style
	 */
	public function participateAction($guid=null) {
        $pollId = $this->getPollId($guid);
		
		$errors = array();
		if($_SERVER["REQUEST_METHOD"] == "POST")
        {	
			//check to make sure everything is valid
			$name =  $_POST["participant_name"];
			if(empty($name)) 
				$errors[] = "Participant name is required";
				
			$unique = $this->registry->mapper->first('\Application\Entities\Poll', array('id' => $pollId))->isUnique;
			if($unique == "true") {
				$max = 0;
				foreach($_POST as $optionId => $priority) {
					$needle = "option_";
					if (substr($optionId, 0, strlen($needle)) === $needle) {
						$max++;
					}
				}
				
				$options = array();
				foreach($_POST as $optionId => $priority) {
					$needle = "option_";
					if (substr($optionId, 0, strlen($needle)) === $needle) {
						if(!is_numeric($priority) || $priority <= 0 || $priority > $max) {
							$errors[] = $priority . " is an invalid rating.";
						}
						$options[] = $priority;
					}
				}
				
				if(count(array_flip($options)) != $max)
					$errors[] = "Non-unique ratings exist";

			} else {
				$max = 5;
				foreach($_POST as $optionId => $priority) {
					$needle = "option_";
					if (substr($optionId, 0, strlen($needle)) === $needle) {
						if(!is_numeric($priority) || $priority <= 0 || $priority > $max) {
							$errors[] = $priority . " is an invalid rating.";
						}
					}
				}
			}
			//if no errors...
			if(empty($errors)) {
				// let's create a new participant
				$person = new \Application\Entities\Person();
				$person->pollId = $pollId;
				$person->name = $name;
				$personId = $this->registry->mapper->insert($person);
				
				// now lets do all of their priorities.
				foreach($_POST as $optionId => $priority) {
					$needle = "option_";
					if (substr($optionId, 0, strlen($needle)) === $needle) {
						// key is the option id, value is the priority
						$answer = new \Application\Entities\Answer();
						$answer->personId = $personId;
						$answer->optionId = substr($optionId,strlen($needle));
						$answer->priority = $priority;
						$this->registry->mapper->insert($answer);
					}
				}
				
				//email the poll creator that someone has participated in his poll
				$poll = $this->registry->mapper->first('\Application\Entities\Poll', array('id' => $pollId));
				$pollOwner = $this->registry->mapper->first('\Application\Entities\User', array('id' => $poll->userId));
				$pollLink = $GLOBALS["registry"]->utils->makeLink("Poll", "index", $guid);

				$to      = $pollOwner->username;
				$subject = "Someone has responded to your poll";
				$message = $person->name . " has responded to your poll entitled '" . $poll->question . "'."
							."  To view the response, visit " . $pollLink . ".";
	
				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/plain; charset=iso-8859-1";
				$headers[] = "From: GroupMatch <no-reply@groupmatch.cs.washington.edu>";
				$headers[] = "Reply-To:  GroupMatch <no-reply@groupmatch.cs.washington.edu>";
				$headers[] = "X-Mailer: PHP/".phpversion();
				$headers = implode("\r\n", $headers);
				mail($to, $subject, $message, $headers);
				
				//redirect back to poll index page
				$this->redirect($pollLink);            
			}
        }
        
        $this->view->headStyles()->addStyle("participate");
        $this->view->topBar()->setPage("participate");
        $this->view->Errors = $errors;
        $poll = $this->registry->mapper->first('\Application\Entities\Poll', array('id' => $pollId));
        $this->view->Poll = $poll;
	}
	
	/*
		Deletes a participant from a poll
		Does validitiy checking to ensure that only the owner may delete the poll
	*/
	public function deleteParticipantAction() {
		$guid = "";
		if($_SERVER["REQUEST_METHOD"] == "POST")
        {
			$guid = $_POST["guid"];
			$personId = $_POST["personId"];
			$pollId = $this->getPollId($guid);
			if($this->isOwner($pollId)) {
				//personIds are unique to each poll and have no correlation to who is logged in
				//so it is ok to delete with respect to this
				$this->registry->mapper->delete('\Application\Entities\Answer', array('personId' => $personId));
				$this->registry->mapper->delete('\Application\Entities\Person', array('id' => $personId));
			}
		}
		$pollLink = $GLOBALS["registry"]->utils->makeLink("Poll", "index", $guid);
		$this->redirect($pollLink);
	}
	
	/**
	 On the user's poll page, there is a link to generate the current answer. This function
	 generates that answer, and then displays it on the same page as the "Happiness meter".
	 */
	public function solutionAction($guid=null)
	{
		$this->view->headStyles()->addStyle("solution");
        $this->view->topBar()->setPage("solution");
		
        $pollId = $this->getPollId($guid);
		// Verify that this exists
		
        $pollId = intval($pollId);
        
		$mapper = $this->registry->mapper;
        
        $poll = $mapper->first('\Application\Entities\Poll', array('id' => $pollId));
        
		$people = $mapper->all('\Application\Entities\Person', array('pollId' => $pollId))->execute();
		$this->view->NoParticipants = false;
        if (count($people) == 0) {
            $this->view->NoParticipants = true;
        }
        else
        {
            $realOptions = $mapper->all('\Application\Entities\Option', array('pollId' => $pollId))->execute();
               
            $options = array();
            foreach($realOptions as $option) {
                $options[] = $option;
            }
            $options[] = null;       
            
            $maxSize = $poll->isUnique ? count($realOptions) : 5;
		    $pollSolution = new \Application\Modules\Main\Models\PollSolution($realOptions, count($people), $maxSize);

		    foreach($people as $person) {
			    $option = $pollSolution->findBestOption($person);
                
			    $pollSolution->addPersonToOption($person, $option);
		    }
                 
		    for ($i = 2; $i <= 10/log(count($options)* count($people)+1, M_E); $i++)
		    {
			    $curBestSolution = null;
                $j = 0;
			    while (($curBestSolution == null
					    || $curBestSolution->getStarValue() < $pollSolution->getStarValue()))
			    {
				    $curBestSolution = clone $pollSolution;
				    $pollSolution = $this->move($pollSolution, $i, $options);
                    $j++;
			    }
		    }

            if ($curBestSolution == null) {
                $curBestSolution = clone $pollSolution;
            }
            
		    // Hand it off to the view
            $this->view->Poll = $poll;
		    $this->view->Solution = $curBestSolution;
        }
		
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
			return $toReturn;
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
					 
					$pollSolution->removePersonFromOption($person, $optionAdd);
				}

				$pollSolution->addPersonToOption($person, $option);
			}
		}            
		return $toReturn;
	}
	
	//returns true if the current person is logged in and is the owner of teh poll,
	//otherwise returns false;
	private function isOwner($pollId) {
		$this->auth = \Saros\Auth::getInstance();
        
        if (!$this->auth->hasIdentity())      
            return false;
		
		$this->auth = \Saros\Auth::getInstance();
		$userId = $this->auth->getIdentity()->id;
		return (bool) $this->registry->mapper->first('\Application\Entities\Poll', array('id' => $pollId, 'userId' => $userId));
	}
}
