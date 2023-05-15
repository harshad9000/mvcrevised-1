<?php

class Controller_Customer extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout  = $this->getLayout();
			$grid = $layout->createBlock('Customer_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Customer not showed.',Model_Core_Message :: FAILURE);
		}
	}

	public function addAction()
	{
		try {	
			$layout = $this->getLayout();
			$customer = Ccc::getModel('Customer');
			$billingAddress = Ccc::getModel('Customer_Address');
			$shippingAddress = Ccc::getModel('Customer_Address');
			$add = $layout->createBlock('Customer_Edit')->setData(['customer' => $customer,'billingAddress' => $billingAddress,'shippingAddress' => $shippingAddress]);
			$layout->getChild('content')->addChild('add',$add);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Customer not added.',Model_Core_Message :: FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$customerId = (int) Ccc::getModel('Core_Request')->getParams('id');
			if (!$customerId) {
				throw new Exception("Invalid Id", 1);
			}
			$layout = $this->getLayout();
			$customer = Ccc::getModel('Customer')->load($customerId);
			if (!$customer) {
				throw new Exception("Invalid Id", 1);
			}
			$billingAddress = $customer->getMyBilling();
			$shippingAddress = $customer->getMyShipping();
			$edit = $layout->createBlock('Customer_Edit')->setData(['customer'=>$customer,'billingAddress' => $billingAddress,'shippingAddress' => $shippingAddress]);

			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Customer not edited.',Model_Core_Message :: FAILURE);
		}
	}

	public function saveAction()
				throw new Exception("Billing address not found.", 1);
			}
			if ($id = $this->getRequest()->getParams('id')) {
				$billingAddress = $customer->getMyBilling();
			
				if (!$billingAddress) 
				{
					throw new Exception("Billing address not found.", 1);
				}
			} 
			else
			{
			  	$billingAddress = Ccc::getModel('Customer_Address');
			  	$billingAddress->customer_id = $customer->customer_id;
			}	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request", 1);
			}

			$postData = $this->getRequest()->getPost('customer');
			if (!$postData)
			{
			 	throw new Exception("Customer data not found.", 1);
			}

			if ($id = $this->getRequest()->getParams('id')) 
			{
			  	$customer = Ccc::getModel('Customer')->load($id);
			  	if (!$customer) {
			  		throw new Exception("Customer not found.", 1);
			  	}
			  	$customer->updated_at = date("Y-m-d H-i-s");
			} 
			else
			{
			  	$customer = Ccc::getModel('Customer');
			  	$customer->created_at = date("Y-m-d H-i-s");
			}

			$customer->setData($postData);
			if (!$customer->save()) {
				throw new Exception("Unable to save customer.", 1);
			}

			$postBilling = $this->getRequest()->getPost('billingAddress');
			if (!$postBilling) {


			$billingAddress->setData($postBilling);
			if (!$billingAddress->save()) 
			{
				throw new Exception("Billing address not found.", 1);
			}

			$customer->billing_address_id = $billingAddress->address_id;

			$postShipping = $this->getRequest()->getPost('shippingAddress');
			if (!$postShipping) {
				throw new Exception("Billing address not found.", 1);
			}
			if ($id = $this->getRequest()->getParams('id')) 
			{
				$shippingAddress = $customer->getMyShipping();

				if (!$shippingAddress) {
					throw new Exception("Shipping address not found.", 1);
			}
			} 
			else{
				$shippingAddress = Ccc::getModel('Customer_Address');
				$shippingAddress->customer_id = $customer->customer_id;
			}

			$shippingAddress->setData($postShipping);
			if (!$shippingAddress->save()) {
				throw new Exception("Shipping address not found.", 1);
			}
			$customer->shipping_address_id = $shippingAddress->address_id;
			$customer->setData($postData);
				if (!$customer->save()) {
				throw new Exception("Unable to save customer.", 1);
			}
			$this->getMessage()->addMessage('Customer saved successfully.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Customer not Saved.',Model_Core_Message :: FAILURE);	
		}
		$this->redirect('grid','customer',null,true);
		
	}

	public function deleteAction()
	{
		try {
			if (!($id = (int)$this->getRequest()->getParams('id'))) {
				throw new Exception("Id not found", 1);
			}
			$customer = Ccc::getModel('Customer')->load($id);

			$billingId = $customer->billing_address_id;
			$billingAddress = Ccc::getModel('Customer_Address')->load($billingId);

			$shippingId = $customer->shipping_address_id;
			$shippingAddress = Ccc::getModel('Customer_Address')->load($shippingId);

			$customer->delete();
			$billingAddress->delete();
			$shippingAddress->delete();

			$this->getMessage()->addMessage('Customer deleted.',Model_Core_Message :: SUCCESS);
		} catch (Exception $e) {
			$this->getMessage()->addMessage('Customer not deleted.',Model_Core_Message :: FAILURE);
		}
		$this->redirect('grid','customer',null,true);
	}
}