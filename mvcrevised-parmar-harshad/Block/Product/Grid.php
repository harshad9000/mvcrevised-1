<?php

class Block_Product_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->getCollection();
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Product');
	}

	public function getCollection()
	{
		$query = "SELECT count('product_id') FROM `product`";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);

		$currentPage = Ccc::getModel('Core_Request')->getParams('p');
		$pager = Ccc::getModel('Core_Pagination');
		$pager->setCurrentPage($currentPage)->setTotalRecords($totalRecord);
		$pager->calculate();
		$this->setPager($pager);
		
		$query = "SELECT * FROM `product` LIMIT {$pager->getStartLimit()},{$pager->getRecordPerPage()}";
		$products = Ccc::getModel('Product')->fetchAll($query);
		return $products;
	}

	protected function _prepareColumns()
	{
		$this->addColumn('product_id',['title' => 'Product Id']);
		$this->addColumn('name',['title' => 'Name']);
		$this->addColumn('cost',['title' => 'Cost']);
		$this->addColumn('SKU',['title' => 'SKU']);
		$this->addColumn('price',['title' => 'Price']);
		$this->addColumn('quantity',['title' => 'Quantity']);
		$this->addColumn('description',['title' => 'Description']);
		$this->addColumn('status',['title' => 'Status']);
		$this->addColumn('color',['title' => 'Color']);
		$this->addColumn('material',['title' => 'Material']);
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
		$this->addButton('product_id',['title' => 'Add New','url' => $this->getUrl('add','product')]);
		return parent::_prepareButtons();
	}
}

?>