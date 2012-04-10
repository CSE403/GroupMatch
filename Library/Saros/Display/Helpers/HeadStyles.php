<?php
namespace Saros\Display\Helpers;

/**
 * This class helps create a list of style tags in layout headers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class HeadStyles extends HelperBase
{
	public $styles = array();

	public function addStyle($name)
	{
		$style = $this->display->getThemeLocation()."StyleSheets/".$name.".css";
		if (!file_exists(ROOT_PATH.$style))
			throw new \Saros\Display\Exception("Stylesheet ".$name." could not be found at ".ROOT_PATH.$style);

		$this->styles[] = $GLOBALS['registry']->config["siteUrl"].$style;

		return $this;
	}

	public function __toString()
	{
		$output = "";
		foreach ($this->styles as $style)
		{
			$output .= '<link rel="stylesheet" type="text/css" href="'.$style.'" />';
		}

		return $output;
	}
}