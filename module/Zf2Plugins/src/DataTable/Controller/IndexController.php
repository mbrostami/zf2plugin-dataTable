<?php
namespace DataTable\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DataTable\Interfaces\DataTableInterface;
use DataTable\Validator\PostData;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{ 
	public function ajaxAction()
	{
		$this->layout("layout/empty");
		$request = $this->getRequest();
	 	if ($request->isPost()) {
	 		$configs = $this->getServiceLocator()->get("Config");
	 		$postInput = $request->getPost();
	 		if (isset($configs['data-table-templates'])) {
		 		if (array_key_exists($postInput['className'], $configs['data-table-templates'])) {
		 			$className = $configs['data-table-templates'][$postInput['className']];
		 			$templateClass = new $className($this); 
		 			$postData = new PostData($templateClass, $postInput);
		 			$data = $templateClass->getAjaxData($postData);
		 			$templateOptions = $templateClass->getOptions();
		 			$checkboxes = false; 
		 			if ($templateOptions) { 
		 				if ($templateOptions) {
		 					foreach ($templateOptions as $configName => $configValue) { 
		 						if ($configName == 'checkbox' And $configName) {
		 							$checkboxes = true;
		 							break;
		 						} 
		 					}
		 					if ($checkboxes) {
		 						$newData = array();
		 						foreach ($data['data'] as $key => $columns) {
		 							$checkboxName = "data-table-checkbox[$key]"; 
		 							if (isset($columns['checkbox'])) {
		 								$checkboxName = $columns['checkbox'];
		 							}
			 						$newData[$key]["<input type='checkbox' id='data-table-checkall'>"] = "<input type='checkbox' class='data-table-checkboxes' name='$checkboxName'>";
		 							foreach ($columns as $columnIndex => $columnValue) {
		 								$newData[$key][$columnIndex] = $columnValue;
		 							}
		 						}
		 						if ($newData) {
		 							$data['data'] = $newData;
		 						}
		 					}
		 				} 
		 			}
		 			$view['data'] = json_encode($data);
		 			$viewModel = new ViewModel();
		 			$viewModel->setVariables($view);
		 			return $viewModel;
		 		} 
	 		} 
	 	}
	 	return;
	}
	
	public function indexAction()
	{ 
		$view = array();
		$configs = $this->getServiceLocator()->get("Config");
		if (! isset($configs['data-table-templates'])) { 
			return "<div class='alert alert-danger'>data-table-templates config is missing</div>";
		}
		$dataTableTemplates = $configs['data-table-templates'];
		return function ($templateObject) use ($view, $dataTableTemplates){ 
			if ($templateObject instanceof DataTableInterface) {
				if (! isset($dataTableTemplates[$templateObject->identity])) {
					return "<div class='alert alert-danger'>Add data-table-template config for \"".$templateObject->identity."\"</div>";
				} 
				$viewModel = new ViewModel($view); 
				$viewModel->setVariable('elementId', $templateObject->elementId);
				$viewModel->setVariable('templateObject', $templateObject); 
				$viewModel->setTemplate("data-table/index/index.phtml");
				return $viewModel;
			} else {
				return "<div class='alert alert-danger'>templateObject format error</div>";
			}
		};
	}
}