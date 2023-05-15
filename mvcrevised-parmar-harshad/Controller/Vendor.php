<?php

class Controller_Vendor extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Vendor_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Vendor not showed.',Model_Core_Message :: FAILURE);
		}	
	}

	public function addAction()
	{
		try {	
		$layout = $this->getLayout();
		$vendor = Ccc::getModel('Vendor');
		$address = Ccc::getModel('Vendor_Address');
    	$add = $layout->createBlock('Vendor_Edit')->setData(['vendor'=>$vendor,'vendorAddress'=>$address]);
		$layout->getChild('content')->addChild('add',$add);
		$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Vendor not added.',Model_Core_Message :: FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$vendorId = (int) Ccc::getModel('Core_Request')->getParams('id');
			if (!$vendorId) {
				throw new Exception("Invalid Id", 1);
				
			}
			$layout = $this->getLayout();
			$vendor = Ccc::getModel('Vendor')->load($vendorId);
			if (!$vendor) {
				throw new Exception("Invalid Id", 1);
			}
			$address = Ccc::getModel('Vendor_Address')->load($vendorId);
			if (!$address) {
				throw new Exception("Invalid Id", 1);
			}
			$edit = $layout->createBlock('Vendor_Edit')->setData(['vendor'=>$vendor,'vendorAddress' => $address]);

			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Vendor not edited.',Model_Core_Message :: FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid request.", 1);
			}

			$postData = $this->getRequest()->getPost('vendor');
			if (!$postData) {
				throw new Exception("Invalid data posted.", 1);
			}
			if ($id = (int)$this->getRequest()->getParams('id')) {
				$vendor = Ccc::getModel('Vendor')->load($id);
				if (!$vendor) {
					throw new Exception("Invalid id.", 1);
				}
			$vendor->updated_at = date("Y-m-d H:i:s");
			}
			else{
				$vendor = Ccc::getModel('Vendor');
				$vendor->created_at = date("Y-m-d H:i:s");
			}
			$vendor->setData($postData);
			if (!$vendor->save()) {
				throw new Exception("Unable to save vendor.", 1);
			}

			$postDataAddress = $this->getRequest()->getpost('address');
			if (!$postDataAddress) {
				throw new Exception("Invalid data posted.", 1);
			}
			if ($id = (int)$this->getRequest()->getParams('id')) {
				$vendorAddress = Ccc::getModel('Vendor_Address')->load($id);
				if (!$vendorAddress) {
					throw new Exception("Invalid id.", 1);
				}
			}
			else{
				$vendorAddress = Ccc::getModel('Vendor_Address');
				$vendorAddress->vendor_id = $vendor->vendor_id;
			}
			$vendor->setData($postData);
			if (!$vendor->save()) {
				throw new Exception("Unable to save vendor.", 1);
			}
			$this->getMessage()->addMessage('Vendor saved successfully.',Model_Core_Message:: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Vendor not Saved.',Model_Core_Message:: FAILURE);	
		}
		$this->redirect('grid','vendor',null,true);
	}

	public function deleteAction()
	{
		try {
			if (!($id = (int) $this->getRequest()->getParams('id'))) {
			throw new Exception("Error Processing Request", 1);
			}
			$vendor = Ccc::getModel('Vendor')->load($id);

			if (!$vendor) {
				throw new Exception("Error Processing Request", 1);
			}
			$vendorAddress = Ccc::getModel('Vendor_Address')->load($id);

			$vendor->delete();
			$vendorAddress->delete();
			$this->getMessage()->addMessage('Vendor deleted.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Vendor not deleted.',Model_Core_Message :: FAILURE);
		}
		$this->redirect('grid','vendor',null,true);
	}
}