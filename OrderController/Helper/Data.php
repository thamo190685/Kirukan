<?php
/**
 * Copyright © 2018 Kirukan . All rights reserved.
 */
namespace Kirukan\OrderController\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	/**
     * @param \Magento\Framework\App\Helper\Context $context
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Json\Helper\Data $jsonHelper,
		\Magento\Sales\Api\Data\OrderInterface $order
	) {
		parent::__construct($context);
		$this->jsonHelper = $jsonHelper;
		$this->order = $order;
	}
	
	/**
	* Get order number
	* return longint
	**/
	public function getOrderNumber()
	{
		$orderNumber = $this->_request->getParam('ordernumber');
		return $orderNumber;
	}
	
	/**
	* Get order details ( order status, total, items, total invoiced )
	* return Json Param
	**/
	public function getOrderDetails()
	{
		$this->orderNumber = $this->getOrderNumber();
		$orderArray = array();
		$orderArray['error_code'] = 0;
			
		if($this->orderNumber){
			$order = $this->order->loadByIncrementId($this->orderNumber);
			
			if(count($order->getData())){
				$orderArray['error_code'] = 1;
				$orderArray['order_status'] = $order->getStatus();
				$orderArray['order_total'] = $order->getGrandTotal();
				$orderArray['order_total_invoiced'] = $order->getTotalInvoiced();
				$orderArray['order_items'] = array();
				
				foreach ($order->getAllItems() as $key => $item)
				{
					$orderArray['order_items'][$key]['item_id'] = $item->getId();
					$orderArray['order_items'][$key]['sku']  = $item->getSku();
					$orderArray['order_items'][$key]['price']  = $item->getPrice();
				}
			}else{
				$orderArray['error_message'] =  __('Incorrect Order Number. Please check your order confirmation email for right order number.');
			}
		}else
		{
			$orderArray['error_code'] = 2;
			$orderArray['error_message'] = __('Order Number is missing');
		}
			
		$encodedOrderData = $this->jsonHelper->jsonEncode($orderArray);
		return $encodedOrderData;
	}
}