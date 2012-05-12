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
        
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $poll = new \Application\Entities\Poll();
            $poll->userId = $this->auth->getIdentity()->id;
            $poll->question = $_POST["title"];
            $poll->description = $_POST["description"];
            
            $this->registry->mapper->save($poll);           
        }
    }
    
    public function logoutAction() {
        $this->auth = \Saros\Auth::getInstance();
        $this->auth->clearIdentity();
        
        $homeLink = $GLOBALS["registry"]->utils->makeLink("Index", "index");
        $this->redirect($homeLink);
    }
}
