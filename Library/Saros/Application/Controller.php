<?php
namespace Saros\Application;

/**
 * This is the base class for all controllers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
abstract class Controller
{
	// Registry Instance
	protected $registry;

	// The view for our controller
	protected $view;

	// Params from the URL
	protected $params;

	function __construct($registry)
	{
		$this->registry = $registry;

		// Call our init hook
		$this->init();
	}

	/**
	* This function is called right when the
	* controller is created. This can be used
	* to set up refrences and instances used throughout
	* the controller
	*
	*/
	protected function init()
	{
	}

	// Set the view
	public function setView($view)
	{
		$this->view = $view;
	}

	public function setParams($params)
	{
		$this->params = $params;
	}
	public function getParam($param)
	{
		if (array_key_exists($param, $this->params))
			return $this->params[$param];

		return null;
	}

	/**
	* Redirect a request to another location
	*
	* @param string $location The location to redirect to
	*/
	public function redirect($location)
	{
		// Dummy vars
		$file = "";
		$line = 0;

		if(!headers_sent($file, $line))
		{
			header("Location: ".$location);
		}
		else
		{
			ob_end_clean();
			?>
			<script type="text/javascript">
			window.location = "<?php echo $location ?>"
			</script>
			<?php
		}

		die();

	}
}