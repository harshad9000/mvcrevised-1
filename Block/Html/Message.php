<?php

class Block_Html_Message extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/message.phtml');
	}
}

?>