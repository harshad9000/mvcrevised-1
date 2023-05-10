<?php

class Block_Customer_Edit extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('customer/edit.phtml');
	}
	
	public function getCollection()
	{
		$customer = $this->getData('customer');
		$billingAddress = $this->getData('billingAddress');
		$shippingAddress = $this->getData('shippingAddress');
		$final = [$customer,$billingAddress,$shippingAddress];
		return $final;
	}
}

