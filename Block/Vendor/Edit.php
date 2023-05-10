<?php

class Block_Vendor_Edit extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/edit.phtml');
	}

	public function getCollection()
	{
		$vendor = $this->getData('vendor');
		$address = $this->getData('address');
		$final = [$vendor,$address];
		return $final;
	}

}

