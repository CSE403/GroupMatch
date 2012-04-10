<?php
namespace Saros\Auth\Identity;
/**
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
class Facebook implements \Saros\Auth\Identity\IIdentity
{
    private $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }
    public function getIdentifier()
    {
        return $this->user["id"];
    }

    public function __get($key)
    {
        if (!isset($this->user[$key])) {
            throw new Exception("User object does not have field ".$key);
        }
        return $this->user[$key];
    }
}

