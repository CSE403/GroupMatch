<?php
namespace Application\Modules\Main\Controllers;

class Index extends \Saros\Application\Controller
{
    public function init() {
       
    }
    
	public function indexAction()
	{                                                        
	}
    
    public function registerAction()
    {
        $this->view->headStyles()->addStyle("register");
    }
}
