<?php
namespace Application\Modules\Main\Controllers;
/**
    The Account controller module houses all the logic used whenever the user does anything on his/her
    account page.
*/
class Account extends \Saros\Application\Controller
{
    private $auth;
    /**
        Constructor for the controller. Called when the user tried to login to his/her account.
        Makes sure that he/she has the right authentication to be there, else redirects to the 
        websites front page.
    */
    public function init() {
        $this->auth = \Saros\Auth::getInstance();
        
        if (!$this->auth->hasIdentity()) {         
            $homeLink = $GLOBALS["registry"]->utils->makeLink("Index");
            $this->redirect($homeLink);
        }
    }
    
    /**
        This method is called whenever the user clicks the button on his homepage to see all
        the polls that the user has created.
    */
    public function indexAction()
    {
        $this->view->headStyles()->addStyle("myPolls");
        $this->view->topBar()->setPage("myPolls");
        
        $user = $this->registry->mapper->first('\Application\Entities\User', array('id' => $this->auth->getIdentity()->id));

        $this->view->Polls = $user->polls;
        //die(var_dump($this->auth->getIdentity()->polls));
    }
    /**
        This method is called whenever the user clicks the button on his/her homepage to 
        create a new poll. This will then display the createpoll page to the user.
    */
    public function createAction()
    {
        $this->view->headStyles()->addStyle("createPoll");
        $this->view->topBar()->setPage("createPoll");
        
		$errors = array();
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {	
			
			//check if everything is valid or not
			$question = $_POST["title"];
			if(empty($question))
				$errors[] = "No question/title added.";
			
			$answer_type = isset($_POST["answer_type"]) ? $_POST["answer_type"] : false;
			if($answer_type === false)
				$errors[] = "No answer type selected.";
				
			//must have at least two categories
			$count = 0;
			$min_answers = 2;
			foreach($_POST as $variable => $value){
				// If they didn't set it's name, then skip it
				if ($value == "")
					continue;
					
				$needle = "option_";
				$limit = "limit_";
				$all = "all_";
				if(substr($variable, 0, strlen($needle)) === $needle &&
					substr($variable,strlen($needle),strlen($limit)) !== $limit &&
					substr($variable,strlen($needle),strlen($all)) !== $all) 
				{
					$count++;
					
					if($count >= $min_answers)
						break;
				}
			}
			if($count < $min_answers)
				$errors[] = "There must be at least 2 answers to the poll";
			
			//if no errors, add in the stuff
			if(empty($errors)) {				
				//die(var_dump($_POST["answer_type"] == "unique" ? "true" : "false"));
				//die(var_dump($_POST));
				$poll = new \Application\Entities\Poll();
				$poll->userId = $this->auth->getIdentity()->id;
				$poll->question = $question;
				
				$poll->description = $_POST["description"];
				do {
					$poll->guid = uniqid('', true);
				} while($this->registry->mapper->first("\Application\Entities\Poll", array("guid" => $poll->guid)) !== false);
				
				$poll->isUnique = $answer_type == "unique" ? "true" : "false";
				
				$pollId = $this->registry->mapper->insert($poll);
				
				$universal_max_size = isset($_POST["option_all_limit"]) ? $_POST["option_all_limit_amount"] : null;
				foreach($_POST as $variable => $value) {
					// If they didn't set it's name, then skip it
					if ($value == "")
						continue;
						
					$needle = "option_";
					$limit = "limit_";
					$amount = "amount_";
					$ola = $needle.$limit.$amount;
					$all = "all_";
					if(substr($variable, 0, strlen($needle)) === $needle &&
						substr($variable,strlen($needle),strlen($limit)) !== $limit &&
						substr($variable,strlen($needle),strlen($all)) !== $all) 
					{
						$index = substr($variable, strlen($needle));
						$option = new \Application\Entities\Option();
						$option->pollId = $pollId;
						$option->name = $value;
						$option->maxSize = isset($_POST[$ola.$index]) ? $_POST[$ola.$index] : $universal_max_size;
						if($option->maxSize == null)
							$option->maxSize = 4294967295; //max integer size in database
						$this->registry->mapper->insert($option);   
					}
				}
				
				$pollLink = $GLOBALS["registry"]->utils->makeLink("Poll", "index", $guid);
				$this->redirect($pollLink);           
			}
        }
		$this->view->Errors = $errors;
    }
	
    public function logoutAction() {
        $this->auth = \Saros\Auth::getInstance();
        $this->auth->clearIdentity();
        
        $homeLink = $GLOBALS["registry"]->utils->makeLink("Index", "index");
        $this->redirect($homeLink);
    }
    
	//deletes a poll if you are the owner
    /*public function deleteAction() {
		
		$pollId = $this->getPollId($guid);
		
		if($this->isOwner($pollId) {
			$this->registry->mapper->delete("\Application\Entities\Poll", array("id" => $pollId));
			$this->registry->mapper->
			$this->registry->mapper->delete("\Application\Entities\Option", array("pollId" => $pollId));
			$this->registry->mapper->delete("\Application\Entities\Person", array("pollId" => $pollId));
			$this->registry->mapper->delete("\Application\Entities\Answer", array("personId" => $personId));
		}
		$accountHome = $GLOBALS["registry"]->utils->makeLink("Account", "index");
		$this->redirect($accountHome);
    }*/
	
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
