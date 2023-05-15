<?php

class Model_Customer_Address_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('Customer_address');
		$this->setPrimaryKey('address_id');
	}
}

?>