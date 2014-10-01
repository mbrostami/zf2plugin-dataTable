<?php
namespace Sample\DataTableTemplates;

use DataTable\Interfaces\DataTableInterface; 
use DataTable\Validator\PostData;
use DataTable\Main\Template; 
/**
 * @author mb.rostami
 */
class SimpleTemplate extends Template implements DataTableInterface
{   
	public $identity = "SimpleTemplate";

	public $canDelete = false;
	public $canEdit = false;
	
	public function checkPermissions()
	{
		$this->canDelete = true; /// check delete permission here 
		$this->canEdit = true; /// check edit permission here 
	}
	
	public function autoload()
	{
		//"field" used for sortColumn 
		$columns = array(
				0 => array("data" => _("Id") , 		"field" => "id"), 
				1 => array("data" => _("Name"), 	"field" => "db_table_name_column"),  
		); 
		if ($this->canEdit) {
			$columns[2] = array("data" => _("Edit"), 	"field" => null,    "bSortable" => false);
		}
		if ($this->canDelete) {
			$columns[3] = array("data" => _("Delete"), 	"field" => null,    "bSortable" => false);
		}
		$this->setColumns($columns);
		
		/// data table options goes here
		$options = array(
				"searching" => false 
		);
		$this->appendOptions($options);
	}
	/**
	 * This method generates array for returning new data to datatable 
	 * @param PostData $postData
	 * @see \DataTable\Interfaces\DataTableInterface::getAjaxData()
	 */
	public function getAjaxData($postData)
	{ 
		/*
		 * Use $this->controller for access to controller methods
		 * You can use models here and send query to database and fetch data 
		 */ 
		$sampleTableData = $this->getMyTableData($postData);
		 
		$result['draw'] 			= $postData->draw;
		$result['recordsTotal'] 	= $sampleTableData['selectCount'];
		$result['recordsFiltered']  = $sampleTableData['selectCount'];
		$i 	  = 0;
		$data = array();  
		foreach ($sampleTableData['data'] as $tableData) {  
			$data[$i][$this->columns[0]['data']] = $tableData['id']; 
			$data[$i][$this->columns[1]['data']] = $tableData['name'];  
			 
			if ($this->canEdit) {
				$data[$i][$this->columns[2]['data']] = '<a href="#edit">'._("Edit").'</a>';
			}
			if ($this->canDelete) {
				$data[$i][$this->columns[3]['data']] = '<a href="#delete">'._("Delete").'</a>';
			}

			$i++;
		}
		$result['data'] = $data ;
		return $result;
	}
	
	/**
	 * This is just a sample method.
	 * You can replace this method with your models function for sort, search, pagination ,...from database by $postData object
	 * $postData object is generated with some ajax inputs.
	 * @param PostData $postData
	 * @return array
	 */
	public function getMyTableData($postData)
	{ 
		/*
		 * var_dump($postData); die; //For debug
		 * object(DataTable\Validator\PostData)[235]
			  public 'limit' => int 10
			  public 'offset' => null
			  public 'orderAs' => string 'asc' (length=3)
			  public 'sortColumn' => string 'id' (length=2) // field
			  public 'draw' => string '1' (length=1)
			  public 'length' => string '10' (length=2)
			  public 'wordSearch' => string '' (length=0)
 
		 */
		$sampleTableData['data'] = array(
				array(
						'id' => 1,
						'name' => 'name-1'
				),
				array(
						'id' => 2,
						'name' => 'name-2'
				),
				array(
						'id' => 3,
						'name' => 'name-3'
				),
				array(
						'id' => 4,
						'name' => 'name-4'
				),
				array(
						'id' => 5,
						'name' => 'name-5'
				),
				array(
						'id' => 6,
						'name' => 'name-6'
				),
		);
		if ($postData->sortColumn == 'id' && $postData->orderAs == 'desc') {
			rsort($sampleTableData['data']);
		}
		if ($postData->sortColumn == 'db_table_name_column' && $postData->orderAs == 'desc') {
			rsort($sampleTableData['data']);
		}
		$sampleTableData['selectCount'] = count($sampleTableData['data']);
		
		return $sampleTableData;
	}
}