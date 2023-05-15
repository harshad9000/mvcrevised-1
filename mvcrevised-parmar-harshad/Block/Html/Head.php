<?php

class Block_Html_Head extends Block_Core_Template
{
	protected $title = null;

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/head.phtml');
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		 $this->title = $title;
		 return $this;
	}

}

?>