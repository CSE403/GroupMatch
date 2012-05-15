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
            ?>
                    <a class="selected">About</a>
                    <a href="<?php echo $register; ?>">Create Account</a>
            <?php    
                }else if ($this->pageName == "register") {
            ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a class="selected">Create Account</a>
            <?php
                }else if ($this->pageName == "myPolls") {
            ?>
                    <!--<a href="<?php echo $about; ?>">About</a>-->
                    <a class="selected">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php
                }else if ($this->pageName == "createPoll") {    
            ?>
                    <!--<a href="<?php echo $about; ?>">About</a>-->
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a class="selected">Create</a>
            <?php
                }else if ($this->pageName == "poll") {
               ?>
                    <!--<a href="<?php echo $about; ?>">About</a>-->
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php
                }else if ($this->pageName == "solution") { 
               ?>
                    <!--<a href="<?php echo $about; ?>">About</a>-->
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php 
                }else if ($this->pageName == "participate") { 
               ?>
                    <a href="<?php echo $about; ?>">About</a>
                    <a href="<?php echo $polls; ?>">Polls</a>
                    <a href="<?php echo $create; ?>">Create</a>
            <?php 
                }
                ?>
        </nav>
        <div class="auth_control">
            <div class="divider"></div>
            <?php 
             	$auth = \Saros\Auth::getInstance();
				$loginLink = $GLOBALS["registry"]->utils->makeLink("Index", "login");
				$logoutLink = $GLOBALS["registry"]->utils->makeLink("Account", "logout");
				if (!$auth->hasIdentity()) 
				{
			?>
				<div class="button_shiv">
					<button class="green" onClick="location.href='<?php echo $loginLink; ?>'">Login</button>
				</div>
			<?php
				}else 
				{
			?>
				<div class="button_shiv">
					<button class="red" onClick="location.href='<?php echo $logoutLink; ?>'">Logout</button>
				</div>
			<?php
				}
			?>
		</div>
		<?php
    }
}