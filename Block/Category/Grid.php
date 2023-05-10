<?php

class Block_Category_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->getCollection();
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Category Method');
	}
	public function getCollection()
	{

		$query = "SELECT count('category_id') FROM `category`";
		$totalRecords = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$currentPage = Ccc::getModel('Core_Request')->getParams('p',1);
		$pager = Ccc::getModel('Core_Pager');
		$pager->setCurrentPage($currentPage)->setTotalRecords($totalRecords);
		$pager->calculate();
		$this->setPager($pager);
		$query = "SELECT * FROM `category` LIMIT $pager->startLimit,$pager->recordPerPage";
		$categories = Ccc::getModel('Category')->fetchAll($query);
		return $categories;
	}

	protected function _prepareColumns()
	{
		$this->addColumn('category_id',['title' => 'Category Id']);
		$this->addColumn('name',['title' => 'Name']);
		$this->addColumn('description',['title' => 'Description']);
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
		$this->addButton('category_id',['title' => 'Add New','url' => $this->getUrl('add','category')]);
		return parent::_prepareButtons();
	}
}

?>