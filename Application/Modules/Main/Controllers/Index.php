<?php
namespace Application\Modules\Main\Controllers;
/**
	The Index controller houses all functionality needed on the website's frontpage, including redirecting
	to the user's homepage if he/she is logged in, or redirecting him to the registration page if the user
	wants to register.
*/
class Index extends \Saros\Application\Controller
{
	/**
		Initializes the page. 
		@ZFR: Does nothing.
	*/
    public function init() {
        $auth = \Saros\Auth::getInstance();
        
        if ($auth->hasIdentity()) {         
            $accountLink = $GLOBALS["registry"]->utils->makeLink("Account");
            $this->redirect($accountLink);
        }
    }
    
    /**
    	@ZFR: Placeholder function for any required logic needed for the user on the front page. 
    	Currently does nothing.
    */
    public function indexAction()
    {      
        $this->view->topBar()->setPage("home");
    }
    
    public function loginAction() {
    	$this->view->headStyles()->addStyle("login");
    	$accountLink = $GLOBALS["registry"]->utils->makeLink("login");
    	
        $errors = array();
        
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (!isset($_POST["email"]) || !isset($_POST["password"]))
            {
                $errors[] = "All fields are required";
            }
            else
            {      
                $result = $this->login($_POST["email"], $_POST["password"]);
                
                $auth = \Saros\Auth::getInstance();
                if (!$auth->hasIdentity()) {
                    $errors[] = "Invalid username and password";
                }
                else
                {
                    // We are logged in
                    $accountLink = $GLOBALS["registry"]->utils->makeLink("Account");
                    $this->redirect($accountLink);
                }
            }
        }
        $this->view->Errors = $errors;
    }
    
    /**
    	Redirects the user to the registration page if the user clicks on the "Register" button.
    */
    public function registerAction()
    {
        $this->view->headStyles()->addStyle("register");
        $this->view->topBar()->setPage("register");
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new \Application\Entities\User();
            $mapper = $this->registry->mapper;
            
            $user->username = $_POST["email"];
            $user->password = $_POST["password"];
        
            $result = $mapper->insert($user);
            
            $this->login($user->username, $user->password);
        }
    }
    
    private function login($username, $password) {
        
        $auth = \Saros\Auth::getInstance();
        $auth->getAdapter()->setCredential($username, $password);        
        $result = $auth->authenticate();
        return $result;
    }
}
