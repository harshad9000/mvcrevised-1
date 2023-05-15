<?php 

class Controller_Product extends Controller_Core_Action 
{
	
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Product_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Product not showed.',Model_Core_Message:: FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$product = Ccc::getModel('Product');
	    	$add = $layout->createBlock('Product_Edit')->setData(['product'=>$product]);
			$layout->getChild('content')->addChild('add',$add);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Product not added.',Model_Core_Message:: FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$productId = (int) Ccc::getModel('Core_Request')->getParams('id');
			if (!$productId) {
				throw new Exception("Invalid Id", 1);
				
			}
			$layout = $this->getLayout();
			$product = Ccc::getModel('Product')->load($productId);
			if (!$product) {
				throw new Exception("Invalid Id", 1);
				
			}
			$edit = $layout->createBlock('Product_Edit')->setData(['product'=>$product]);

			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Product not edited.',Model_Core_Message:: FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request.", 1);
			}
			$postData = $this->getRequest()->getPost('product');

			if ($id = $this->getRequest()->getParams('id')) {
				$product = Ccc::getModel('Product')->load($id);
				if (!$product) {
					throw new Exception("Product not found.", 1);
				}
				$product->updated_at = date('Y-m-d H:i:s');
			}
			else{
				$product = Ccc::getModel('product');
				if (!$product) {
					throw new Exception("Product not found", 1);
				}
				$product->created_at = date("Y-m-d H-i-s");
			}
			$product->setData($postData);
			if (!$product->save()) {
				throw new Exception("Product not saved.", 1);
			}
			$this->getMessage()->addMessage('Product saved successfully.',Model_Core_Message:: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Product not Saved.',Model_Core_Message:: FAILURE);	
		}
		$this->redirect('grid','product',null,true);
	}


	public function deleteAction()
	{
		try {
			if (!($id = (int)$this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$product = Ccc::getModel('Product')->load($id);
			if (!$product) {
				throw new Exception("Product not found", 1);
			}
			$product->delete();
			$this->getMessage()->addMessage('Product deleted.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Product not deleted.',Model_Core_Message :: FAILURE);
		}
	$this->redirect('grid','product',null,true);
	}

}
