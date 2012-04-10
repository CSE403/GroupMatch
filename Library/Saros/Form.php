<?php
namespace Saros;

/**
 * Form class, creates and validates forms
 *
 * Possible Errors:
 * 		Two submit buttons
 * 		Two elements of the same name
 *
 * @todo Break Chain / Don't Break Chain on validation
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Form
{
	const DATA_GET = "get";
	const DATA_POST = "post";

	// Methods we can get our data
	protected $dataMethods = array("get","post");

	// What method are we using
	protected $method;

	// Action for the form
	protected $action;

	// Submit button
	protected $submit;

	protected $errors = array();

	protected $name;

	/**
	 * Array of all the elements in the form
	 *
	 * @var array All the elements in the form
	 */
	protected $elements = array();

	function __construct($name)
	{
		$this->name = $name;

		// Defaults
		$this->setMethod(self::DATA_POST);
		// Default action is the current controller and action
		$action = array($GLOBALS['registry']->router->getController(), $GLOBALS['registry']->router->getAction());
		$this->setAction($action);
	}

	public function getName()
	{
		return $this->name;
	}


	public function setAction($action)
	{
		// You can either pass a string action or an array of controller/action
		if (is_array($action))
			$this->action = call_user_func_array(array($GLOBALS['registry']->utils, "makeLink"), $action);
		else
			$this->action = $action;
		return $this;
	}
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * Set the method access variable
	 *
	 * @param string $type either get, or post
	 */
	public function setMethod($type)
	{
		// If the method is one of our allowed methods
		if (in_array($type, $this->dataMethods))
			$this->method = $type;

		return $this;
	}

	/**
	 * Get the method we are using to get our data
	 *
	 * @return string
	 */
	public function getMethod()
	{
		if (!isset($this->method))
			return Form::DATA_POST;

		return $this->method;
	}

	/**
	 * Add an element to the form
	 *
	 * @param string $type Name of the type to add
	 * 		Example: text, Text, Checkbox, textarea
	 * @param string $name Name of the element
	 * @return Saros_Form_Element Instance of the newly created Form Element
	 */
	public function addElement($type, $name)
	{
		// Prepend "Form_Element_" to type so we can get the right class
		$class = "Form\\Element\\".ucfirst($type);
		$object = new $class;

		// Set the element's name
		$object->setName($name);

		// Add it to our elements array with the name as the key
		$this->elements[$object->getName()] = $object;

		// Return the object to allow chaining
		return $object;
	}

	public function getElement($name)
	{
		if (array_key_exists($name, $this->elements))
			return $this->elements[$name];

		return null;
	}

	/**
	 * Add a submit button to the form
	 *
	 * @param string $value Value that will show on the submit button
	 */
	public function addSubmit($value)
	{
		$this->submit = new Form\Element\Submit();

		$this->submit->setText($value);
	}

	// Pass the post data to each element.
	/**
	 * Distribute form data to each element
	 *
	 * @param array $data Key/Values for the form elements
	 * 		Recieved from $_POST/$_GET/ or a custom array
	 */
	public function distributeData($data)
	{
		//print_r($_POST);
		//print_r($this->elements);

		// Go through each key/value in $_POST/$_GET/what have you
		foreach($data as $key=>$value)
		{
			// if we have an element with a matching name
			if (array_key_exists($key, $this->elements))
			{
				// Then set the value
				$this->elements[$key]->setValue($value);
				//echo "key exists<br />";
			}
			//else
				//echo "key doesn't exist <br />";
		}
	}

	/**
	 * Validate the form
	 *
	 * @param array $data Key/Values for the form elements
	 * 		Recieved from $_POST/$_GET/ or $_REQUEST
	 * @return bool Whether the form is valid
	 */
	public function validate()
	{
		$data = array();
		// What data do we check?
		switch ($this->getMethod())
		{
			case "get":
				$data = $_GET;
				break;
			default:
				$data = $_POST;
				break;
		}

		//print_r($data);
		//print_r($_POST);

		// We start with a valid flag
		$valid = true;

		// Distribute the data to the elements
		$this->distributeData($data);

		foreach ($this->elements as $element)
		{
			// If the element is not valid
			if (!$element->validate())
			{
				$this->errors = array_merge($this->errors, $element->getErrors());
				// Set our flag to invalid
				$valid = false;
			}
		}


		return $valid;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function render()
	{
		// Get the current class name
		$className = get_class($this);

		// We only want the last string after the underscore
		$formName = array_pop(explode("\\", $className));

		// Where we expect a template to be
		$pathName = ROOT_PATH.'Application/Views/Forms/'.$formName.'.php';
		$defaultPath = ROOT_PATH.'Library/Display/Default/Form.php';

		// Whether we should use the default form template
		$useDefault = false;

		// If our form template doesn't exist
		if (!file_exists($pathName))
		{
			// Try the default one. It should be there
			if (!file_exists($defaultPath))
				throw new Exception('Form display template does not exist for '.$formName.' at '.$pathName);
			else
				$useDefault = true;
		}
		if ($useDefault)
			$pathName = $defaultPath;


		?>
		<form id="form_<?php echo $this->getName()?>" action="<?php echo $this->getAction()?>" method="<?php echo $this->getMethod() ?>">
		<?php

			require_once($pathName);

		?>
		</form>
		<?php
	}
}