<?php
namespace Saros\Auth\Adapter;

/**
* This is the Auth adapter for Spot Compatible Databases
*
* @copyright Eli White & SaroSoftware 2010
* @license http://www.gnu.org/licenses/gpl.html GNU GPL
*
* @package SarosFramework
* @author Eli White
* @link http://sarosoftware.com
* @link http://github.com/TheSavior/Saros-Framework
*
*/
class Facebook implements IAdapter
{
    private $facebook;

    public function __construct(\Saros\Service\Facebook\Api $facebook)
    {
        $this->facebook = $facebook;
    }

    /**
    * Authenticate the request
    *
    * @return Saros_Auth_Result the result of the authentication
    *
    * @see Saros_Auth_Result
    */
    public function authenticate()
    {
        $user = $this->facebook->getUser();

        if($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $p = $this->facebook->api('/me');
                $identity = new \Saros\Auth\Identity\Facebook($p);
                
                return new \Saros\Auth\Result(\Saros\Auth\Result::SUCCESS, $identity);
            } catch (FacebookApiException $e) {
                error_log($e);
            }
        }
        
        return new \Saros\Auth\Result(\Saros\Auth\Result::FAILURE);
    }
}

