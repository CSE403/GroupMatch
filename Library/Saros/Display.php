<?php
namespace Saros;

/**
 * This class helps create the displays for each page
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 *
 * @todo Add support for parse() to return a string of content
 */
class Display extends Core\Registry
{
	protected static $instance = null;

	protected $registry;

	// The theme we are currently loading views from
	protected $themeLocation;

	// The name of the layout we want to use. Not validated
	protected $layoutName = null;

	// pointer to our functions class.
	protected $functions = null;

	// Whether we should show the view for the current page we are on
	protected $showAction = true;

	/**
	* An array of initialized view helpers
	* for the __call method
	*
	* @var array
	*/
	protected $viewHelpers = array();

	/**
	* An array of class names that are
	* initialized view helpers
	*
	* @var mixed
	*/
	protected $registeredHelpers = array();

	protected $headStyles;
	protected $headScripts;  
    
	public static function getInstance($registry)
	{
		if (self::$instance == null)
		{
			self::$instance = new self($registry);
		}

		return self::$instance;
	}

	/**
	* We are using the singleton pattern, thus the constructor
	* is private
	*
	* @param Saros_Core_Registry $registry
	* @return Saros_Display
	*/
	private function __construct(Core\Registry $registry)
	{
		$this->registry = $registry;

		$this->init();
	}

	public function init()
	{
		$this->registerHelper("headStyles", "\\Saros\\Display\\Helpers\\HeadStyles");
		$this->registerHelper("headScripts", "\\Saros\\Display\\Helpers\\HeadScripts");
	}

	/**
	* Set the theme to use
	*
	* @param string $themeName The name of the theme to use
	*/
	public function setTheme($themeName)
	{
		$this->themeLocation = "Application/Themes/".$themeName."/";
		if (!is_dir(ROOT_PATH.$this->themeLocation))
			throw new Display\Exception("Theme ".$themeName." not found at ".ROOT_PATH.$themeLocation);
	}

	/**
	* A simple getter for the theme location
	*
	* @return string The path to the current theme directory
	*/
	public function getThemeLocation()
	{
		return $this->themeLocation;
	}

	/**
	* The name of the layout to use. This location isn't validated
	* at the time this function is run since it depends on the theme.
	*
	* @param string $layoutName The name of the layout to use.
	*/
	public function setLayout($layoutName)
	{
		$this->layoutName = $layoutName;
	}

	public function parse($return = false)
	{
		// Include the view if we haven't turned off the view
		if ($this->show())
		{
			$layoutLocation = ROOT_PATH.$this->themeLocation."Layouts/".$this->layoutName.".php";
			if (!file_exists($layoutLocation))
				throw new Display\Exception("Layout ".$this->layoutName." not found at ".$layoutLocation);

			require_once($layoutLocation);
		}
	}

	public function show($var = null)
	{
		if (!is_null($var))
		{
			if (!is_bool($var))
				throw new Display\Exception("Show() expects a boolean, '".gettype($var)."' given");
			else
				$this->showAction = $var;

			return;
		}
		return $this->showAction;
	}

	// Gives our views a content function
	public function content()
	{
		$module = $GLOBALS['registry']->router->getModule();
		$logic = $GLOBALS['registry']->router->getController();
		$action = $GLOBALS['registry']->router->getAction();

		// $action will have Action at the end. We need to remove this to find it in the view location
		$action = substr($action, 0, -6);

		$viewLocation = ROOT_PATH.$this->themeLocation."Controllers/".$module."/".$logic."/".$action.".php";

		if(!file_exists($viewLocation))
			throw new Display\Exception("The view for module: '".$module."', Controller: '".$logic."', Action: '".$action."' does not exist at ".$viewLocation);

		require_once($viewLocation);
	}

	/**
	* Register a view helper
	*
	* @param string $name The alias to use for the helper
	* @param string $className The class name of the helper to register
	* @throws Saros_Display_Exception if the the alias has already been registered
	* @throws Saros_Display_Exception if the class name has already been registered
	* @throws Saros_Display_Exception if $name or $className are not strings
	*/
	public function registerHelper($name, $className)
	{
		if (isset($this->viewHelpers[$name]))
			throw new Display\Exception("The alias '".$name."' is already registered to '".get_class($this->viewHelpers[$name])."'");

		if (in_array($className, $this->registeredHelpers))
			throw new Display\Exception("The view helper '".$className."' has already been registered");

		if (!is_string($name))
			throw new Display\Exception("The alias must be a string, '".gettype($name)."' given");

		if (!is_string($className))
			throw new Display\Exception("The class name must be a string, '".gettype($name)."' given");
                
		$helper = new $className($this);
		$this->viewHelpers[$name] = $helper;

	}

	/**
	* This attempts to run a view helper
	*
	* @param string $alias The alias of the viewhelper to find
	* @param mixed $arguments This is not used
	* @return Object the view helper with the alias of $alias
	*/
	public function __call($alias, $arguments)
	{
		if (isset($this->viewHelpers[$alias]))
		{
			return $this->viewHelpers[$alias];
		}
        else
        {
            throw new Display\Exception("The view helper '".$alias."' does not exist");
        }  
	}
}