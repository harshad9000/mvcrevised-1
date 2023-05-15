<?php

class Model_Core_Table_Collection
{
	protected $data = [];

	public function setData(array $data)
	{
		$this->data =array_merge($this->data,$data) ;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}	