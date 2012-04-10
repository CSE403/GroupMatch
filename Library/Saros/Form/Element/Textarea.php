<?php
namespace Saros\Form\Element;

/**
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Textarea extends \Saros\Form\Element
{
	/*
		Validate the value of the element
	*/
	public function validate()
	{
		$valid = true;
		foreach ($this->validators as $validator)
		{
			// If it doesn't validate return false and break
			if (!$validator['validator']->isValid($this->getValue()))
			{
				$this->errors = array_merge($this->errors, $validator['validator']->getErrors());

				// return now if we are breaking on false
				if ($validator['breakOnFalse'])
					return false;

				$valid = false;
			}
		}

		return $valid;
	}

	public function setRows($rows)
	{
		$this->addAttribute("rows", $rows);
		return $this;
	}
	public function setCols($cols)
	{
		$this->addAttribute("cols", $cols);
		return $this;
	}

	public function render()
	{
		if ($this->getRequired())
		{
			$this->addAttribute("class", "required");
		}

		$attributes = "";
		foreach($this->getAttributes() as $key=>$value)
		{
			$attributes .= " ".$key.'= "'.$value.'"';
		}
		?>
		<textarea <?php echo $attributes?> name="<?php echo $this->getName()?>"><?php echo $this->getValue()?></textarea>
		<?php
	}
}