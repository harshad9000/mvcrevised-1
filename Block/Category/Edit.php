<?php

class Block_category_Edit extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('category/edit.phtml');
		
	}

	public function getCollection()
	{
		$category = $this->getData('category');
		return $category;
}
	
}
?>
