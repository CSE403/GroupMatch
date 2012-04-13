<?php
namespace Application\Modules\Main\Controllers;

class Poll extends \Saros\Application\Controller
{
    public function init() {
       
    }
    
    public function indexAction()
    {
        $this->view->Version = \Saros\Version::getVersion();
    }
    
    public function solutionAction()
    {
        $this->view->Version = \Saros\Version::getVersion();
    }
}
