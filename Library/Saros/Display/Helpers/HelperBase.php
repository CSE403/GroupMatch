<?php
namespace Saros\Display\Helpers;

/**
 * This abstract class provides base functionality for display helpers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
abstract class HelperBase
{
	protected $display = null;

	public function __construct($display)
	{
		$this->display = $display;
	}
}