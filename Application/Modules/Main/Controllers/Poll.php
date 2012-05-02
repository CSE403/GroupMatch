<?php       
    namespace Application\Modules\Main\Controllers;

    class Poll extends \Saros\Application\Controller
    {
        public function init() {

        }

        public function indexAction()
        {
            $this->view->headStyles()->addStyle("poll");
        }

        public function solutionAction($pollId)
        {     
            // Verify that this exists
            $pollId = intval($pollId);

            $mapper = $this->registry->mapper;                                                

            $people = $mapper->all('\Application\Entities\Person', array('pollId' => $pollId));
            $options = $mapper->all('\Application\Entities\Option', array('pollId' => $pollId));

            $pollSolution = new \Application\Modules\Main\Models\PollSolution($options, count($people));

            $arrayOfPeople = array();
            foreach($people as $person) {
                $option = $pollSolution->findBestOption($person);
                $pollSolution->addPersonToOption($person, $option);

                if($pollSolution->hasConflicts())
                {
                    $arrayOfPeople[] = $person;
                    $pollSolution->removePersonFromOption($person, $option);
                }
            }

            foreach($arrayOfPeople as $person) {
                $option = $pollSolution->findBestOption($person);
                $pollSolution->addPersonToOption($person, $option);

                if($pollSolution->hasConflicts())
                {
                    $pollSolution = $this->move($pollSolution, 4, $options);
                }
            }

            // Hand it off to the view
            $this->view->Solution = $pollSolution; 
        }

        /**
        * return \Application\Modules\Main\Models\PollSolution
        */
        private function move(\Application\Modules\Main\Models\PollSolution $pollSolution, $depth, $options) {
            // PollSolutions we are working with 
            $toReturn = null;
            $curBest = null;

            if ($depth == 0 && !$pollSolution->hasConflicts()){
                return clone $pollSolution;
            }

            if($depth == 0){
                return toReturn;
            }

            foreach($options as $option) {
                foreach($pollSolution->getPeopleForOption($option) as $person) {
                    $pollSolution->removePersonFromOption($person, $option);
                    
                    foreach($options as $optionAdd) {
                        $pollSolution->addPersonToOption($person, $optionAdd);
                        if ($pollSolution->possibleToMakeValidIn($depth-1)){
                            $curBest = $this->move($pollSolution, $depth-1, $options);
                            if ($toReturn == null
                                || ($curBest != null && $curBest->getStarValue() > $toReturn->getStarValue())) {
                                $toReturn = $curBest;
                            }
                        }
                           
                        $pollSolution->removePersonToOption($person, $optionAdd);
                    }
                    
                    $pollSolution->addPersonFromOption($person, $option);
                }
            }

            return $toReturn;
        }
    }
