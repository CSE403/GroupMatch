<?php
namespace Application\Modules\Main\Controllers;

class Account extends \Saros\Application\Controller
{
    public function init() {
       
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
