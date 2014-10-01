<?php
namespace DataTable\Templates;

use DataTable\Interfaces\DataTableInterface;
use Application\Helper\BaseController;
use DataTable\Validator\PostData;
use DataTable\Main\Template;

class ConfigsTemplateTable extends Template implements DataTableInterface
{   
	public $identity = 'configsTbl';

	public function autoload()
	{
		$columns = array(
				array("data" => "Label", 		"field" => "label"),
				array("data" => "Group", 		"field" => "group", "bSortable" => false),
				array("data" => "Option Label", "field" => null,    "bSortable" => false),
				array("data" => "Value", 		"field" => "value", "bSortable" => false),
				array("data" => "Edit", 		"field" => null,    "bSortable" => false)
		); 
		$this->setColumns($columns);
		$options = array(
			"searching" => false
		);
		$this->appendOptions($options);
	}
	/**
	 * @param PostData $postData
	 * @see \DataTable\Interfaces\DataTableInterface::getAjaxData()
	 */
	public function getAjaxData($postData)
	{  
		$level    	  	  = $this->baseController->userData->level;
		$configTable  	  = $this->baseController->getModel('Management', 'ConfigTable'); 
		$configTableData  = $configTable->getByTableData(array(
			'level >= ?' => $level
		), $postData->limit, $postData->offset, $postData->sortColumn, $postData->orderAs);  
		if ($configTableData) {
			foreach ($configTableData as &$config) {
				if($config["type"] == 'select' OR $config["type"] == 'multiselect') {
					$config["options"] = $this->baseController->getModel('Management', 'ConfigTable')->getChilds($config["id"]);
				}
			}   
		}  
		$result['draw'] = $postData->draw;
		$result['recordsTotal'] = $configTable->selectCount;
		$result['recordsFiltered'] = $configTable->selectCount;
		$i = 0; 
		$data = array();
		foreach ($configTableData as $configData) {
			$data[$i]["Label"] = $configData['label'];
			$data[$i]["Group"] = $configData['group'];
			if (isset($configData['options'])) {
				if ($configData['type'] == 'multiselect') {
					$label = array();
					foreach ($configData['options'] as $option) {
						if (in_array($option['value'],explode(";", $configData['value']))) {
							$label[] = $option['label'];
						}
					}
					$data[$i]["Option Label"] = implode(";", $label); 
				} else {
					foreach ($configData['options'] as $option) {
						if ($option['value'] == $configData['value']) { 
							$data[$i]["Option Label"] = $option['label'];
							break 1;
						}
					}
				}
			} else {
				$data[$i]["Option Label"] = "----";
			} 
			$data[$i]["Value"] = $configData['value']; 
			$data[$i]["Edit"] = '<a href="/management/config/edit/'.$configData['id'].'">Edit</a>';
			$i++;
		}  
		$result['data'] = $data ;
		return $result;
	} 

}