<?php

class Controller_Salesman extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Salesman_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Salesman not showed.',Model_Core_Message :: FAILURE);
		}
	}

	public function addAction()
	{
		try {
			
		$layout = $this->getLayout();
		$salesman = Ccc::getModel('Salesman');
		$address = Ccc::getModel('Salesman_Address');
    	$add = $layout->createBlock('Salesman_Edit')->setData(['salesman'=>$salesman,'salesmanAddress'=>$address]);
		$layout->getChild('content')->addChild('add',$add);
		$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Salesman not added.',Model_Core_Message :: FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$id = $this->getRequest()->getParams('id');
			$salesman = Ccc::getModel('Salesman')->load($id);
			if (!$salesman) {
				throw new Exception("Salesman not found.", 1);
			}
			$salesmanAddress = Ccc::getModel('Salesman_Address')->load($id);
			if (!$salesmanAddress) {
				throw new Exception("Salesman address not found", 1);
			}
			$layout = $this->getLayout();
			$edit = $layout->createBlock('Salesman_Edit')->setData(['salesman'=>$salesman,'salesmanAddress' => $salesmanAddress]);

			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Salesman not edited.',Model_Core_Message :: FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invaloid Request", 1);
			}

			$postData = $this->getRequest()->getPost('salesman');
			if (!$postData) {
				throw new Exception("Salesman data not found.", 1);
			}

			if ($id = $this->getRequest()->getParams('id')) {
				$salesman = Ccc::getModel('Salesman')->load($id);
				$salesman->updated_at = date("Y-m-d H-i-s");
			}
			else{
				$salesman = Ccc::getModel('Salesman');
				$salesman->created_at = date("Y-m-d H-i-s"); 
			}

			$salesman->setData($postData);
			if (!$salesman->save()) {
				throw new Exception("Salesman not saved.", 1);
			}

			$postAddressData = $this->getRequest()->getPost('address');
			if (!$postAddressData) {
				throw new Exception("Salesman address data not found.", 1);
			}

			if ($id = $this->getRequest()->getParams('id')) {
				$salesmanAddress = Ccc::getModel('Salesman_Address')->load($id);
			}
			else{
				$salesmanAddress = Ccc::getModel('Salesman_Address');
				$salesmanAddress->salesman_id = $salesman->salesman_id; 
			}

			$salesman->setData($postData);
			if (!$salesman->save()) {
				throw new Exception("Salesman addresss not saved.", 1);
			}
			$this->getMessage()->addMessage('Salesman saved successfully.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Salesman not Saved.',Model_Core_Message :: FAILURE);	
		}
		$this->redirect('grid','salesman',null,true);
	}
	public function deleteAction()
	{
		try {
			if (!($id = $this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$salesman = Ccc::getModel('Salesman')->load($id);
			if (!$salesman) {
				throw new Exception("Error Processing Request", 1);
			}
			$salesman->delete();

			$salesmanAddress = Ccc::getModel('Salesman_Address');
			if (!$salesmanAddress) {
				throw new Exception("Salesman Address not saved", 1);
			}
			$salesmanAddress->delete();
			$this->getMessage()->addMessage('Salesman deleted.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Salesman not deleted.',Model_Core_Message :: FAILURE);
		}
	$this->redirect('grid','salesman',null,true);
	} 
}