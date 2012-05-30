<?php
namespace Application\Modules\Main\Controllers;

class Setup extends \Saros\Application\Controller
{
    public function init() {
       
    }
    
    public function indexAction()
    {   
        $this->view->show(false);
        
        $this->registry->mapper->migrate('\Application\Entities\Answer');
        $this->registry->mapper->migrate('\Application\Entities\Option');
        $this->registry->mapper->migrate('\Application\Entities\Person');
        $this->registry->mapper->migrate('\Application\Entities\Poll');  
        $this->registry->mapper->migrate('\Application\Entities\User');                                           
    }
    
    public function resetAction() {
        $this->view->show(false);
        $this->registry->mapper->truncateDatasource('\Application\Entities\Answer');
        $this->registry->mapper->truncateDatasource('\Application\Entities\Option');
        $this->registry->mapper->truncateDatasource('\Application\Entities\Person');
        $this->registry->mapper->truncateDatasource('\Application\Entities\Poll');  
        $this->registry->mapper->truncateDatasource('\Application\Entities\User');
    }
}
