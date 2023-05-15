<?php

class Controller_Category extends Controller_Core_Action
{
	public function gridAction()
	{
		try {	
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Category_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Category not showed.',Model_Core_Message :: FAILURE);
		}
	}

	public function addAction()
	{
		try {	
			$layout = $this->getLayout();
			$category = Ccc::getModel('Category');
	    	$add = $layout->createBlock('Category_Edit')->setData(['category'=>$category]);
			$layout->getChild('content')->addChild('add',$add);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Category not added.',Model_Core_Message :: FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$categoryId = (int) Ccc::getModel('Core_Request')->getParams('id');
			if (!$categoryId) {
				throw new Exception("Invalid Id", 1);
				
			}
			$layout = $this->getLayout();
			$category = Ccc::getModel('Category')->load($categoryId);
			if (!$category) {
				throw new Exception("Invalid Id", 1);
				
			}
			$edit = $layout->createBlock('Category_Edit')->setData(['category'=>$category]);

			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Category not edited.',Model_Core_Message :: FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request.", 1);
			}
			$postData = $this->getRequest()->getPost('category');

			if ($id = $this->getRequest()->getParams('id')) {
				$category = Ccc::getModel('Category')->load($id);
				if (!$category) {
					throw new Exception("Category not found.", 1);
				}
				$category->updated_at = date('Y-m-d H:i:s');
			}
			else{
				$category = Ccc::getModel('Category');
				if (!$category) {
					throw new Exception("Category not found", 1);
				}
				$category->created_at = date("Y-m-d H-i-s");
			}
			$category->setData($postData);
			if (!$category->save()) {
				throw new Exception("Category not saved.", 1);
			}
			$this->getMessage()->addMessage('Category saved successfully.',Model_Core_Message::SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Category not Saved.',Model_Core_Message::FAILURE);	
		}
		$this->redirect('grid','category',null,true);
	}
	public function deleteAction()
	{
		try {
			if (!($id = (int)$this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$category = Ccc::getModel('Category')->load($id);
			if (!$category) {
				throw new Exception("Category not found", 1);
			}
			$category->delete();
			
			$this->getMessage()->addMessage('Category deleted.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Category not deleted.',Model_Core_Message :: FAILURE);
		}
	$this->redirect('grid','category',null,true);
	}
}