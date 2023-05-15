<?php

class Block_Customer_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->getCollection();
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Customer');
	}
	public function getCollection()
	{
		$query = "SELECT count('customer_id') FROM `customer`";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);

		$currentPage = Ccc::getModel('Core_Request')->getParams('p');
		$pager = Ccc::getModel('Core_Pagination');
		$pager->setCurrentPage($currentPage)->setTotalRecords($totalRecord);
		$pager->calculate();
		$this->setPager($pager);
		
		$query = "SELECT * FROM `customer` LIMIT {$pager->getStartLimit()},{$pager->getRecordPerPage()}";
		$customers = Ccc::getModel('Customer')->fetchAll($query);
		return $customers;	
	}

	protected function _prepareColumns()
	{
		$this->addColumn('customer_id',['title' => 'Customer Id']);
		$this->addColumn('first_name',['title' => 'First Name']);
		$this->addColumn('last_name',['title' => 'Last Name']);
		$this->addColumn('email',['title' => 'Email']);
		$this->addColumn('gender',['title' => 'Gender']);
		$this->addColumn('mobile',['title' => 'Mobile']);
		$this->addColumn('status',['title' => 'Status']);
		$this->addColumn('created_at',['title' => 'Created_at']);
		$this->addColumn('updated_at',['title' => 'Updated_at']);

		return parent::_prepareColumns();
	}


	protected function _prepareActions()
	{
		$this->addAction('edit',['title' => 'Edit','method' => 'getEditUrl']);
		$this->addAction('delete',['title' => 'Delete','method' => 'getDeleteUrl']);
		return parent::_prepareActions();
	}


	protected function _prepareButtons()
	{
		$this->addButton('Customer_id',['title' => 'Add New','url' => $this->getUrl('add','customer')]);
		return parent::_prepareButtons();
	}
}

?>