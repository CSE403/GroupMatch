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
class Submit
{
	protected $text;

	public function setText($value)
	{
		$this->text = $value;
	}
	public function getText()
	{
		return $this->text;
	}

	public function render()
	{
		?>
		<input type="submit" id="submit" value="<?php echo $this->getText()?>" />
		<?php
	}
}