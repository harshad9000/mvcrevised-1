<?php

class Controller_Core_Front
{
	protected $request = null;

	public function setRequest($request)
	{
		$this->request = $request;
	}

	public function getRequest()
	{
		if ($this->request) {
			return $this->request;
		}
		$request = new Model_Core_Request();
		$this->setRequest($request);
		return $request;
	}
    

    public function init()
    {
       $request = $this->getRequest();
       $controllerName = $request->getControllerName();

       $controllerClassName = 'Controller_'.ucwords($controllerName,'_');
       $controllerPathName = str_replace('_','/',$controllerClassName);

       require_once "{$controllerPathName}.php";

       $controller = new $controllerClassName;
       $action = $request->getActionName()."Action";
   
       if (!method_exists($controller,$action)) {
       		$controller->errorAction($action);
       }else{
       	$controller->$action();
       }
    }
}