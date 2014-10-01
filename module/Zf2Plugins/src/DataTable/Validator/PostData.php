<?php
namespace DataTable\Validator;

use DataTable\Interfaces\DataTableInterface;
class PostData
{
	public $limit;
	public $offset;
	public $orderAs = 'desc';
	public $sortColumn = 'id';
	public $draw = 1;
	public $length = 10;
	public $wordSearch;
	
	public function __construct(DataTableInterface $template, $postData)
	{ 
		$offset = $postData['start'];
		$limit  = $postData['length'];
	
		$columnIndex  = $postData['order'][0]['column'];
		$orderAs  	  = $postData['order'][0]['dir'];
		$sortColumn = false;
		if (isset($template->options['checkbox']) AND $template->options['checkbox']) {
			$columnIndex--;
		}
		if (isset($template->columns[$columnIndex])) {
			$sortColumn = $template->columns[$columnIndex]['field'];
			if (! in_array($orderAs, array("asc", "desc"))) {
				$orderAs = "desc";
			} 
		}
		if ($offset > 0) {
			$this->offset = (int)$offset;
		}
		if ($limit > 0) {
			$this->limit = (int)$limit;
		} 
		if ($sortColumn) {
			$this->sortColumn = $sortColumn;
			$this->orderAs = $orderAs;
		}  
		$this->wordSearch = $postData['search']['value'];
		$this->draw = $postData['draw'];
		$this->length = $postData['length']; 
	} 
}