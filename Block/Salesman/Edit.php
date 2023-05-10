<?php

class Block_Salesman_Edit extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/edit.phtml');
	}

	public function getRow()
	{
		$salesman = $this->getData('salesman');
		$address = $this->getData('address');
		$final = [$salesman,$address];
		return $final;
	}
}

