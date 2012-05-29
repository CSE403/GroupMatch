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
    	$this->view->headStyles()->addStyle("about");
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
        $this->view->pw_min_len = 6;
		$errors = array();
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new \Application\Entities\User();
            $mapper = $this->registry->mapper;
            
            $user->username = $_POST["email"];
            
            // Some salt.
            $user->salt = "sadf93";
			$origPassword = $_POST["password"];
            
            $user->password = sha1($user->salt.$origPassword);
            
			$password2 = $_POST["re_password"];
			
			
			if(strlen($origPassword) < $this->view->pw_min_len) {
				$errors[] = "Passwords must be at least " . $this->view->pw_min_len . " characters long.";
			}
			
			if($password2 !== $origPassword) {
				$errors[] = "Passwords do not match.";
			}
			
			
			
			if(!$this->isEmail($user->username)) {
				$errors[] = "Username is not an email address.";
			} elseif(false !== $mapper->first('\Application\Entities\User', array('username' => $user->username))) {
				$errors[] = "Email address is already associated with an account.";
			}
			
			if(empty($errors)) {
				$result = $mapper->insert($user);
				
				$this->login($user->username, $origPassword);
				
				$auth = \Saros\Auth::getInstance();
				if ($auth->hasIdentity()) {
				$to      = $pollOwner->username;
					$subject = "Welcome to GroupMatch";
					$message = "Welcome to GroupMatch.  Our website is dedicated to making your " . 
								"process of matching people to preferences extremely easy.  " .
								"To get started, login to your account using the following information:" .
								"\n\n" .
								"USERNAME: " . $user->username;
								"\n\n" .
								"PASSWORD: " . $origPassword;
								"\n\n" .
								"(Note: This username and password combination has been sent you for record ".
								"keeping purposes.  Please save this email.)".
								"\n\n" .
								"From that point you can begin creating polls and sending out links to " . 
								"the people that you want to respond to the polls.  To view the optimal " .
								"way to group the people that have responded to your polls into the categories " .
								"that you have chosen, simply visit the poll page, and click the 'View Solution' button." .
								"\n\n" .
								"Thanks for Joining GroupMatch!";
		
					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/plain; charset=iso-8859-1";
					$headers[] = "From: GroupMatch <no-reply@groupmatch.cs.washington.edu>";
					$headers[] = "Reply-To:  GroupMatch <no-reply@groupmatch.cs.washington.edu>";
					$headers[] = "X-Mailer: PHP/".phpversion();
					$headers = implode("\r\n", $headers);
					mail($to, $subject, $message, $headers);
				
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
