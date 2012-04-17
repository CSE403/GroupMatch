<?php
namespace Application\Modules\Main\Controllers;

class Account extends \Saros\Application\Controller
{
    public function init() {
        $auth = \Saros\Auth::getInstance();
        
        if (!$auth->hasIdentity()) {
            $homeLink = $GLOBALS["registry"]->utils->makeLink("Index", "index");
            $this->redirect($homeLink);
        }
    }
    
    public function indexAction()
    {
        $this->view->Version = \Saros\Version::getVersion();
    }
    
    public function createAction()
    {
        $this->view->Version = \Saros\Version::getVersion();
    }
}
