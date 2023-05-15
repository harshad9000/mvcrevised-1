<?php

class Model_Core_Table
{
	protected $data = [];
	protected $resource = null;
	protected $collection = null;
	protected $resourceClass = 'Model_Core_Resource_Resource';
	protected $collectionClass = 'Model_Core_Resource_Collection';

	function __construct()
	{
	}

	public function setId($id)
	{
		$this->data[$this->getResource()->getPrinmaryKey()] = (int)$id;
		return $this;
	}

	public function getId()
	{
		$primaryKey = $this->getResource()->getPrimaryKey();
		return (int)$this->$primaryKey;
	}

	public function setResourceClass($resourceClass)
	{
		$this->resourceClass = $resourceClass;
		return $this;
	}

	public function getResourceClass()
	{
		if ($this->resourceClass) {
			return $this->resourceClass;
		}

		$resourceClass = new ($this->resourceClass)();
		$this->setResourceClass($resourceClass);
		return $resourceClass;
	}

	public function setCollectionClass($collectionClass)
	{
		$this->collectionClass = $collectionClass;
		return $this;
	}

	public function getCollectionClass()
	{
		if ($this->collectionClass) {
			return $this->collectionClass;
		}

		$collectionClass = new ($this->collectionClass)();
		$this->setCollectionClass($collectionClass);
		return $collectionClass;
	}

	public function getResourceName()
	{
		return $this->getResource()->getResourceName();
	}

	public function getPrimaryKey()
	{
		return $this->getResource()->getPrimaryKey();
	}

	public function setResource($resource)
	{
		$this->resource = $resource;
		return $this;
	}

	public function getResource()
	{
		if ($this->resource) {
			return $this->resource;
		}

		$resource = new ($this->resourceClass)();
		$this->setResource($resource);
		return $resource;
	}

	public function __set($key,$value)
	{
		$this->data[$key] = $value;
	}

	public function __get($key)
	{
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}
		return null;
	}

	public function setData(array $data)
	{
		$this->data =array_merge($this->data,$data) ;
		return $this;
	}

	public function getData($key=null)
	{
		if ($key == null) {
			return $this->data;
		}
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}
		return null;
	}

	public function addData($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function removeData($key=null)
	{
		if ($key == null) {
			$this->data = [];
		}
		if (array_key_exists($key,$this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}

	public function fetchAll($query)
	{
		$result = $this->getResource()->fetchAll($query);
		if (!$result) {
			return false;
		}

		foreach ($result as &$row) {
			$row = (new $this)->setData($row)->setResource($this->getResource());
		}
		return $result;
	}

	public function fetchRow($query)
	{
		$result = $this->getResource()->fetchRow($query);
		if ($result) {
			$this->data = $result;
			return $this;
		}
		return false;
	}

	public function delete()
	{
		$id = $this->getData($this->getPrimaryKey());
		if (!$id) {
			return false;
		}

		$condition[$this->getPrimaryKey()] = $id;
		$result = $this->getResource()->delete($condition);
		if ($result) {
			// $this->removeData();
			return true;
		}
		return false;
	}

	public function load($id,$column = null)
	{
		if (!$column) {
			$column = $this->getPrimaryKey();
		}
		$query = "SELECT * FROM `{$this->getResourceName()}` WHERE `{$column}` = {$id}";
		// print_r($query);
		// die();
		$result = $this->getResource()->fetchRow($query);
		if ($result) {
			$this->data = $result;
		}
		return $this;
	}

	public function save()
	{
		if (!array_key_exists($this->getPrimaryKey(), $this->data)) {
			$id = $this->getResource()->insert($this->data);
			if ($id) {
				$this->load($id);
				return $this;
			}
			return false;
		
		}else{
			$id = $this->getData($this->getPrimaryKey());
			$condition[$this->getPrimaryKey()] = $id;

			$result = $this->getResource()->update($this->data, $condition);
			if($result){
				$this->load($id);
				return $this;
			}
			return false;		
		}
	}
}

