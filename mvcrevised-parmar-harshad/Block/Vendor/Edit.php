<?php

class Block_Vendor_Edit extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/edit.phtml');
	}
}

