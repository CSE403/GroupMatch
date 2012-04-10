<?php
namespace Saros\Form;

/**
 * This is a parent class for all Form Elements
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
abstract class Element
{
	/**
	 * Name of the element
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The visible text for the element
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * The description text for the element
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Validators on the element
	 *
	 * @var array
	 */
	protected $validators = array();

	/**
	 * Current value of the element
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Whether the element is required. If true, it adds a class to the element
	 *
	 * @var bool
	 */
	protected $required = false;

	/**
	 * Extra attributes to the element
	 *
	 * @var array
	 */
	protected $attributes = array();

	protected $errors = array();

	/**
	 * Set the name of the element
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	public function getName()
	{
		return $this->name;
	}

	public function setLabel($text)
	{
		$this->label = $text;
		return $this;
	}
	public function getLabel()
	{
		return $this->label;
	}



	/**
	 * Add a validator to the element
	 *
	 * @param string $validator Name of the validator
	 * @param array $options Validator specific options
	 * @param bool $breakOnFalse Whether to not check other validators if this one is false
	 * @return Saros_Form_Element Reference of the element
	 */
	public function addValidator($validator, $options = array(), $breakOnFalse = false)
	{
		// Create the instance of the validator
		$class = "\\Saros\\Form\\Validator\\".ucfirst($validator);

		$array = array
		(
			'validator'	=> new $class($options),
			'breakOnFalse' => $breakOnFalse,
			'options'	=>	$options
		);

		$this->validators[] = $array;

		// Return a reference of the element so we can chain
		return $this;
	}

	/**
	 * Sets the value of the element
	 *
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * Get the value of the element
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		// Should we print html special chars?
		return htmlspecialchars($this->value);
	}

	public function hasErrors()
	{
		return count($this->errors) != 0;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	public function hasDescription()
	{
		return strlen($this->description) > 0;
	}
	public function getDescription()
	{
		return $this->description;
	}

	public function setRequired($required)
	{
		$this->required = $required;
		return $this;
	}
	public function getRequired()
	{
		return $this->required;
	}

	public function addAttribute($key, $value)
	{
		$this->attributes[$key] = $value;
		return $this;
	}
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * Validates the element
	 *
	 * @return bool
	 */
	abstract public function validate();

	/**
	 * Render the element
	 *
	 */
	abstract public function render();
}