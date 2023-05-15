<?php

class Model_Core_View
{
	protected $template = null;
	protected $data = null;

	function __construct()
	{

	}

	public function __unset($key)
	{
		unset($this->data[$key]);
	}

	public function __set($key,$value)
	{
		$this->data[$key] = $value;
	}

	public function __get($key)
	{
		if (!array_key_exists($key,$this->data)) {
			return null;
		}
		return $this->data[$key];
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData($key = null)
	{
		if ($key == null) {
			return $this->data;
		}
		if (array_key_exits($key,$this->data)) {
			return $this->data[$key];
		}
		return null;
	}

	public function setTemplate($template)
	{
		$this->template = $template;
		return $this;
	}

	public function getTemplate()
	{
		return $this->template;
	}

	public function render()
	{
		require "View".DS.$this->getTemplate();
	}

	public function getUrl($action = null,$controller = null,$params = [],$reset = false)
	{
		return Ccc::getModel('Core_Url')->getUrl($action,$controller,$params,$reset);
	}
}