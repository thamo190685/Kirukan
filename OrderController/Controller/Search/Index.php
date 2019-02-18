<?php
namespace Kirukan\OrderController\Controller\Search;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;
	
    /*** @param \Magento\Framework\App\Action\Context $context      */
    public function __construct(
		Context $context, 
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Kirukan\OrderController\Helper\Data $data
	)
    {
        $this->resultPageFactory = $resultPageFactory;
		$this->helper = $data;
        parent::__construct($context);
    }
	
    /**
     * Get Order Details.
     *
     * @return JSON Order details
     */
    public function execute()
    {
        // Call Helper function to get order details //
		echo $this->helper->getOrderDetails();
		die;
    }
}