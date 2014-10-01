<?php
namespace DataTable\Main;

use Zend\Mvc\Controller\AbstractActionController;

class Template
{ 
	/**
	 * Html table columns
	 * @var array
	 */
	public $columns;
	/**
	 * Html element id for using by data table
	 * @var string
	 */
	public $elementId;
	
	/**
	 * Identity from plugin.data-table.config.php file that points to the class full namespace.
	 * For sending with datatable ajax as className
	 * @var string
	 */
	public $identity;
	
	public $options;
	/**
	 * Fills by ajax controller
	 * @var \Zend\Mvc\Controller\AbstractActionController
	 */
	protected $controller;
	
	private $appendFlag = false;
	
	public function __construct(AbstractActionController $controller = null)
	{
		if ($controller) { 
			$this->controller = $controller;
			$this->checkPermissions();
		}
		$this->autoload(); 
		$this->defaultOptions();
	}
 
	public function checkPermissions()
	{
		return;	
	}
	
	public function getOptions()
	{
		return $this->options;
	}
	
	public function appendOptions($options)
	{ 
		$this->appendFlag = true;
		if (is_array($this->options)) {
			$this->options = array_merge($this->options, $options);
		} else {
			$this->options = $options;			
		}
	}
	
	public function setOptions($options)
	{
		$this->options = $options;
	}
	
	public function getColumns()
	{
		return $this->columns;
	}
	
	public function setColumns($columns)
	{
		$this->columns = $columns;
		$this->options['columns'] = $columns; 
	}
	
	private function defaultOptions()
	{
		$defaults = array(
// 			"paging" => false,//disable|enable paging for the table
// 			"scrollY" => "400", //enable scrolling in the table
// 			"searching" => true, //disable|enable search 
// 			"ordering" => true, //disable|enable ordering 
			"serverSide" => true, 
// 			"aoColumnDefs" => array(
// 				array( 'bSortable' => false, 'aTargets' => array(1))
// 			) 
			"columns" =>  $this->columns
		);  
		$options = $defaults;
		if ($this->appendFlag) {
			if (is_array($this->options)) {
				$options = array_merge($options, $this->options);
			}
		}
		$this->setOptions($options);
	}  
}