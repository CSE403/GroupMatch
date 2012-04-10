<?php
namespace Saros\Core;

/**
 * This class takes the url route and loads the applicable controller / action
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Router
{
	// Array containing the parts of the URL path
	private $path = array();

	private $route = array(
		"module"	=> "",
		"controller"	=> "",
		"action"	=> "",
		"params"	=> array()
		);

	private $instance;


	public function getRoute()
	{
		if (!empty($_GET['act']))
			$this->path = explode('/',$_GET['act']);

		return $this->path;
	}
	/**
	 * Gets the route information (Module, Controller, page, and parameters) from the URL
	 *
	 */
	public function parseRoute()
	{
		/*** get the route from the url ***/
		$parts = $this->getRoute();

		// Not a module, load up the default module
		if (!isset(\Application\Setup::$defaultModule))
			throw new Exception("The default module has not been defined in the application setup file.");

		// set the default module
		$this->route["module"] = \Application\Setup::$defaultModule;

		$modFolderPath = ROOT_PATH."Application/Modules/";
		/**
		 * First part is either a module or controller
		 */
		if(isset($parts[0]))
		{
			/**
			 * We have a first part, it is either a module or controller
			 *
			 * It is a module if we have a folder with that name inside the Application
			 * directory AND it has a Setup.php
			 *
			 */

			// First check if it is a module
			$mod = ucfirst($parts[0]);
			$modPath = $modFolderPath.$mod;
			if (is_dir($modPath))
			{
				/**
				 * We have that directory, does not necessarily mean
				 * it is a module. Have to check it for a setup file
				 */
				if(file_exists($modPath."/Setup.php"))
				{
					$this->route["module"] = $mod;
					/**
					 * We are taking this value as the module,
					 * remove it from the route array
					 */
					array_shift($parts);
				}
			}
		}
		// At this point we can rely that $this->route["module"] has been set correctly

		$class = "\\Application\\Modules\\".$this->getModule()."\\Setup";

		if (!property_exists($class, "defaultController"))
			throw new Exception("The default controller has not been defined in the module setup file.");

		$props = get_class_vars($class);

		// Set our controller to default
		$this->route["controller"] = $props["defaultController"];

		// Check if we have another url path (controller)
		if (isset($parts[0]) )
		{
			/**
			 * We are taking this value as the module,
			 * remove it from the route array
			 */
			$controller = ucfirst(array_shift($parts));
			$controllerPath = $modFolderPath.$this->route["module"]."/Controllers";
			if (is_dir($controllerPath))
			{
				/**
				 * We have that directory, does not necessarily mean
				 * it is a controller. Have to check it for a controllers directory
				 */
				if(file_exists($controllerPath."/".$this->route["controller"].".php"))
				{
					$this->route["controller"] = $controller;
				}
			}
		}

		/**
		 * We now know for sure that module and controller is set correctly
		 *
		 * All we have left to check is our action file
		 */
		if (!property_exists($class, "defaultAction"))
			throw new Exception("The default action has not been defined in the logic file.");

		// Set our controller to default
		$this->route["action"] = $props["defaultAction"]."Action";

		if (!method_exists($this->getClassName(), $this->route["action"]))
			throw new Exception("The default action '".$this->route["action"]."' has not been implemented in the '".$this->route["controller"]."' controller.");

		// Check if we have another url path (controller)
		if (isset($parts[0]) )
		{
			// We don't uppercase this one, action names are camelCased
			$action = array_shift($parts)."Action";

			if (method_exists($this->getClassName(), $action))
			{
				$this->route["action"] = $action;
			}
		}

		/**
		 * Module, Controller, Action is now correct
		 * Split apart the rest of the parameters
		 */
		while(count($parts) > 0)
		{
            
			$param = array_shift($parts);
			if (strpos($param, "=") !== false)
			{
				$paramParts = explode("=",$param);
				$this->route["params"][$paramParts[0]] = $paramParts[1];
			}
			else
			{
				$this->route["params"][] = $param;
			}
		}                             
	}

	private function getClassName()
	{
		return "\\Application\\Modules\\".ucfirst($this->getModule())."\\Controllers\\".ucfirst($this->getController());
	}

	public function createInstance(\Saros\Core\Registry $registry)
	{
		// Make a new class
		$className = $this->getClassName();
		$this->instance = new $className($registry);
		$this->instance->setParams($this->getParams());

	}
    
    public function setupModule() {
        // Run the setup for the module
        $class = "\\Application\\Modules\\".$this->getModule()."\\Setup";
        
        if(method_exists($class, "doSetup"))
        {
            $setup = new $class;
            $setup->doSetup($GLOBALS['registry']);
        }
    }

	/**
	* Load the actual controller
	*/
	public function run()
	{
		// Set the display instance for the class
		//$controller->setDisplay(new Saros_Core_Display())

        
        /*** check if the action is callable ***/
        if (!is_callable(array($this->instance, $this->getAction())))
            $this->action = 'index';

		/*** run the action and pass the parameters***/
		call_user_func_array(array($this->instance, $this->getAction()), $this->getParams());
	}

	public function getInstance()
	{
		return $this->instance;
	}
	public function getModule()
	{
		return $this->route["module"];
	}
	public function getController()
	{
		return $this->route["controller"];
	}
	public function setController($controller)
	{
		$this->route["controller"] = $controller;
	}
	public function getAction()
	{
		return $this->route["action"];
	}
	public function setAction($action)
	{
		$this->route["action"] = $action;
	}
	public function getParams()
	{
		return $this->route["params"];
	}
}