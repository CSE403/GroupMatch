<?php
namespace Application\Modules\Main\Controllers;

class Setup extends \Saros\Application\Controller
{
    public function init() {
       
    }
    
    public function indexAction()
    {   
        $this->view->show(false);
        
        $this->registry->mapper->migrate('\Application\Entities\Answers');
        $this->registry->mapper->migrate('\Application\Entities\Options');
        $this->registry->mapper->migrate('\Application\Entities\Persons');
        $this->registry->mapper->migrate('\Application\Entities\Polls');  
        $this->registry->mapper->migrate('\Application\Entities\Users');                                           
    }
}
