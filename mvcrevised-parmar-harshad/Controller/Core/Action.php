<?php

class Controller_Core_Action
{
   protected $adapter = null;
   protected $request = null;
   protected $url = null;
   protected $view = null;
   protected $layout = null;
   protected $message = null;
   protected $session = null;

   public function setAdapter($adapter)
   {
         $this->adapter = $adapter;
         return $this;
   }

   public function getAdapter()
   {
         if ($this->adapter) {
            return $this->adapter;
         }
         $adapter = new Model_Core_Adapter();
         $this->setAdapter($adapter);
         return $this->adapter;
   }

   public function setMessage($message)
   {
         $this->message = $message;
         return $this;
   }

   public function getMessage()
   {
         if ($this->message) {
            return $this->message;
         }
         $message = new Model_Core_Message();
         $this->setMessage($message);
         return $this->message;
   }

   public function setSession($session)
   {
         $this->session = $session;
         return $this;
   }

   public function getSession()
   {
         if ($this->session) {
            return $this->session;
         }
         $session = new Model_Core_Session();
         $this->setSession($session);
         return $this->session;
   }

   protected function setRequest(Model_Core_Request $request)
   {
      $this->request = $request;
      return $this;
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

   public function setUrl(Model_Core_Url $url)
   {
      $this->url = $url;
      return $this;
   }

   public function getUrl()
   {
      if ($this->url) {
         return $this->url;
      }
      $url = new Model_Core_Url();
      $this->setUrl($url);
      return $url;
   }

   public function setView(Model_Core_view $view)
   {
      $this->view = $view;
      return $this;
   }

   public function getView()
   {
      if ($this->view) {
         return $this->view;
      }
      $view = new Model_Core_View();
      $this->setView($view);
      return $view;
   }

   protected function setLayout(Block_Core_Layout $layout){
      $this->layout = $layout;
      return $this;
   }

   public function getLayout(){
      if ($this->layout) {
         return $this->layout;
      }
      $layout = new Block_Core_Layout();
      $this->setLayout($layout);
      return $layout;
   }

   

   public function redirect($action = null,$controller = null,$params = [],$reset = false)
   {
      $url = $this->getUrl()->getUrl($action,$controller,$params,$reset);
      header("location:{$url}");
      exit();
   }

   public function render()
   {
      $this->getView()->render();
   }

   public function getTemplate($templatePath){
      require "View".DS.$templatePath;
   }
   
   public function errorAction($action)
   {
      throw new Exception("method: {$action} does not exits");
   }
}