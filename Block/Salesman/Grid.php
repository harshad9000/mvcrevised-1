<?php

class Block_Salesman_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->getCollection();
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Salesman Method');
	}
	public function getCollection()
	{
		$query = "SELECT count('salesman_id') FROM `salesman`";
		$totalRecords = Ccc::getModel('Core_Adapter')->fetchOne($query);

		$currentPage = Ccc::getModel('Core_Request')->getParams('p',1);
		$pager = Ccc::getModel('Core_Pager');
		$pager->setCurrentPage($currentPage)->setTotalRecords($totalRecords);
		$pager->calculate();
		$this->setPager($pager);
		
		$query = "SELECT * FROM `salesman` LIMIT $pager->startLimit,$pager->recordPerPage";
		// print_r($query);
		// die();
		$salesmanes = Ccc::getModel('salesman')->fetchAll($query);
		return $salesmanes;

	}

	protected function _prepareColumns()
	{
		$this->addColumn('salesman_id',['title' => 'Salesman Id']);
		$this->addColumn('first_name',['title' => 'First Name']);
		$this->addColumn('last_name',['title' => 'Last Name']);
		$this->addColumn('email',['title' => 'Email']);
		$this->addColumn('gender',['title' => 'Gender']);
		$this->addColumn('mobile',['title' => 'Mobile']);
		$this->addColumn('status',['title' => 'Status']);
		$this->addColumn('company',['title' => 'Company']);
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
		$this->addButton('salesman_id',['title' => 'Add New','url' => $this->getUrl('add','salesman')]);
		return parent::_prepareButtons();
	}
}

?>