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
			
		}
	}

	public function addAction()
	{
		$layout = $this->getLayout();
		$salesman = Ccc::getModel('Salesman');
		$address = Ccc::getModel('Salesman_Address');
    	$add = $layout->createBlock('Salesman_Edit')->setData(['salesman'=>$salesman,'salesmanAddress'=>$address]);
		$layout->getChild('content')->addChild('add',$add);
		$layout->render();
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
			$this->getView()->setTemplate('salesman/edit.phtml')->setData(['salesman'=>$salesman,'salesmanAddress'=>$salesmanAddress]);
			$this->render();
		} catch (Exception $e) {
			
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

			$salesmanAddress->setData($postAddressData);
			if (!$salesmanAddress->save()) {
				throw new Exception("Salesman addresss not saved.", 1);
			}

		} catch (Exception $e) {
			
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
		} catch (Exception $e) {
			
		}
	$this->redirect('grid','salesman',null,true);
	} 
}