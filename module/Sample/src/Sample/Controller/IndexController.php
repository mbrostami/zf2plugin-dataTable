<?php
namespace Sample\Controller;
  
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sample\DataTableTemplates\SimpleTemplate;
 
class IndexController extends AbstractActionController 
{
  	public function indexAction()
  	{
  		$simpleTemplate = new SimpleTemplate($this); 
  		$simpleTemplate->elementId = "zfDataTableHtmlId";
  		$view['simpleTemplate'] = $simpleTemplate;
  		return new ViewModel($view); 
  	}
}