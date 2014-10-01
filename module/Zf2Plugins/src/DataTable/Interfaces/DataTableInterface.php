<?php
namespace DataTable\Interfaces;

use Zend\Mvc\Controller\AbstractActionController;
use DataTable\Validator\PostData;
/**
 * @author mbrostami <mb.rostami.h@gmail.com>
 */
interface DataTableInterface
{  
	 public function __construct(AbstractActionController $controller);
	 
	 /**
	  * Get array of data with given parameters which send by data table ajax.
	  * @param PostData $postData
	  */
	 public function getAjaxData($postData);
	 
	 /**
	  * Set options and columns for datatable
	  */
	 public function autoload();
	 
}