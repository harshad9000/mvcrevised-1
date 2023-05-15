<?php

class Model_Product extends Model_Core_Table
{
	public function getStatus()
	{
		if ($this->status) {
			return $this->status;
		}
		return Model_Product_Resource::STATUS_DEFAULT;
	}

	public function getStatusText($status)
	{
		$statuses = $this->getResource()->getStatusOptions();
		if (array_key_exists($this->status,$statuses)) {
			return $statuses[$this->status];
		}
		return $statuses[Model_Product_Resource::STATUS_DEFAULT];
	}

	public function __construct()
   {
      parent::__construct();

      $this->setResourceClass('Model_Product_Resource');
      $this->setCollectionClass('Model_Product_Collection');
   }
}
