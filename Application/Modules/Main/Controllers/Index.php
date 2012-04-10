<?php
namespace Application\Modules\Main\Controllers;

class Index extends \Saros\Application\Controller
{
    public function init() {
       
    }
    
	public function indexAction()
	{
		$this->view->Version = \Saros\Version::getVersion();
	}
}
