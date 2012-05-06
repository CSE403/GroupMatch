<?php
namespace Application\Themes\Helpers;
/**
 * This class helps create a list of script tags in layout headers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class TopBar extends \Saros\Display\Helpers\HelperBase
{
    private $pageName;
    
    public function setPage($pageName) {
        $this->pageName = $pageName;    
    }
    
    public function render() {
        ?>
        <nav>
            <?php
                $register = $GLOBALS["registry"]->utils->makeLink("Index", "register");
                $about = $GLOBALS["registry"]->utils->makeLink("Index", "index");
                $create = $GLOBALS["registry"]->utils->makeLink("Account", "create");
                $polls = $GLOBALS["registry"]->utils->makeLink("Account", "index");
                
                if ($this->pageName == "home") {
                    $login_req = true;
            ?>
                    <a class="selected">About</a>
                    <a href="<?php echo $register; ?>">Create Account</a>
            <?php    
                }else if ($this->pageName == "register") {
                    $login_req = true;
            ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a class="selected">Create Account</a>
            <?php
                }else if ($this->pageName == "myPolls") {
                    $login_req = false;
            ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a class="selected">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php
                }else if ($this->pageName == "createPoll") {
                    $login_req = false;
            ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a class="selected">Create</a>
            <?php
                }else if ($this->pageName == "poll") {
                    $login_req = false;
               ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php
                }else if ($this->pageName == "solution") {
                    $login_req = false;
               ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php 
                }else if ($this->pageName == "participate") {
                    $login_req = false;
               ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php 
                }
                ?>
        </nav>
         <?php 
                $authClass = "logout";
                if ($login_req) {
                    $authClass = "login";
                }
            ?>
            <div class="auth_control <?php echo $authClass; ?>">
                <div class="divider"></div>
                <?php 
                    $loginLink = $GLOBALS["registry"]->utils->makeLink("Account");
                    if ($login_req) 
                    {
                ?>
                        <form name="login">
                            <form name="login">
                             <button class="icon green" onClick="">Login</button>
                             <input name="email" type="email" placeholder="Email" required="required">
                             <input name="password" type="password" placeholder="Password" required="required">
                             <button onClick="location.href='<?php echo $loginLink; ?>'" class="green" type="submit">Login</button>
                             <a href="">Forgot Password</a>
                        </form>
                <?php
                    }
                    else 
                    {
                ?>
                        <form name="logout">
                            <button onClick="location.href='<?php echo $about; ?>'" class="red" type="submit" name="logout">Logout</button>
                        </form>
                <?php
                    }
                ?>
            </div>
        <?php
    }
}