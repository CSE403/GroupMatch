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
	
	//returns true if it is a valid email address, otherwise false
	private function isEmail($email) {
		// First, we check that there's one @ symbol, 
		// and that the lengths are right.
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			// Email invalid because wrong number of characters 
			// in one section or wrong number of @ symbols.
			return false;
		}
		
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i])) {
			  return false;
			}
		}
		
		// Check if domain is IP. If not, 
		// it should be valid domain name
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|?([A-Za-z0-9]+))$",$domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
	}
}
