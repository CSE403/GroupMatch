<?php
namespace Application\Modules\Main\Controllers;
/**
    The Account controller module houses all the logic used whenever the user does anything on his/her
    account page.
*/
class Account extends \Saros\Application\Controller
{
    /**
        Constructor for the controller. Called when the user tried to login to his/her account.
        Makes sure that he/she has the right authentication to be there, else redirects to the 
        websites front page.
    */
    public function init() {
        $auth = \Saros\Auth::getInstance();
        
        if (!$auth->hasIdentity()) {
            $homeLink = $GLOBALS["registry"]->utils->makeLink("Index", "index");
            //$this->redirect($homeLink);
        }
    }
    
    /**
        This method is called whenever the user clicks the button on his homepage to see all
        the polls that the user has created.
    */
    public function indexAction()
    {
        $this->view->headStyles()->addStyle("myPolls");
    }
    /**
        This method is called whenever the user clicks the button on his/her homepage to 
        create a new poll. This will then display the createpoll page to the user.
    */
    public function createAction()
    {
        $this->view->headStyles()->addStyle("createPoll");
    }
}
