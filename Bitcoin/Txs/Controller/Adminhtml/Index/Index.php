<?php
namespace Bitcoin\Txs\Controller\Adminhtml\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Backend\App\Action{
	protected $_resultPageFactory;
	public function __construct(Context $context, PageFactory $pageFactory){
		parent::__construct($context);
		$this->_resultPageFactory=$pageFactory;
	}
	public function execute(){
		$resultPage=$this->_resultPageFactory->create();
		$resultPage->setActiveMenu("Bitcoin_Txs::txs");
		$resultPage->getConfig()->getTitle()->prepend(__("Bitcoin Transaction Information"));
		return $resultPage;
	}
}