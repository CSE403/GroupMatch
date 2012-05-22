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
		$this->view->topBar()->setPage("login");

    	
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
                
                if (!$result->isSuccess()) {
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
        
		$errors = array();
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new \Application\Entities\User();
            $mapper = $this->registry->mapper;
            
            $user->username = $_POST["email"];
			$user->password = $_POST["password"];
			$password2 = $_POST["re_password"];
			
			
			if($password2 !== $user->password) {
				$errors[] = "Passwords do not match.";
			}
			
			
			
			if(!$this->isEmail($user->username)) {
				$errors[] = "Username is not an email address.";
			} elseif(false !== $mapper->first('\Application\Entities\User', array('username' => $user->username))) {
				$errors[] = "Email address is already associated with an account.";
			}
			
			if(empty($errors)) {
				$result = $mapper->insert($user);
				
				$this->login($user->username, $user->password);
				
				$auth = \Saros\Auth::getInstance();
				if ($auth->hasIdentity()) {
					// We are logged in
					$accountLink = $GLOBALS["registry"]->utils->makeLink("Account");
					$this->redirect($accountLink);
				}
			}
						
        }
		$this->view->Errors = $errors;
    }
    
	//authenticates the username and password and returns a credentials object
    private function login($username, $password) {
        
        $auth = \Saros\Auth::getInstance();
        $auth->getAdapter()->setCredential($username, $password);        
        $result = $auth->authenticate();
        return $result;
    }
	
	/** Checks is the provided email address is formally valid
	 *  @param string $email email address to be checked
	 *  @return true if the email is valid, false otherwise
	 */
	private function isEmail($email) {
	  $regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
	  if ( !preg_match($regexp, $email) ) {
		   return false;
	  }
	  return true;
	}
}
