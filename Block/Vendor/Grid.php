<?php

class Block_Vendor_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->getCollection();
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Vendor Method');
	}
	public function getCollection()
	{
		$query = "SELECT count('vendor_id') FROM `vendor`";
		$totalRecords = Ccc::getModel('Core_Adapter')->fetchOne($query);

		$currentPage = Ccc::getModel('Core_Request')->getParams('p',1);
		$pager = Ccc::getModel('Core_Pager');
		$pager->setCurrentPage($currentPage)->setTotalRecords($totalRecords);
		$pager->calculate();
		$this->setPager($pager);
		$query = "SELECT * FROM `vendor` LIMIT $pager->startLimit,$pager->recordPerPage";
		$vendores = Ccc::getModel('vendor')->fetchAll($query);
		return $vendores;

	}

	protected function _prepareColumns()
	{
		$this->addColumn('vendor_id',['title' => 'Vendor Id']);
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
		$this->addButton('vendor_id',['title' => 'Add New','url' => $this->getUrl('add','vendor')]);
		return parent::_prepareButtons();
	}
}

?>