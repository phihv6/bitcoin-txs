<?php
namespace Bitcoin\Txs\Controller\Adminhtml\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Bitcoin\Txs\Model\TxsFactory;
use Magento\Framework\Registry;
class Search extends \Magento\Backend\App\Action{
	protected $_resultPageFactory;
	const ADMIN_RESOURCE = "Bitcoin_Txs::txs_save";
	public function __construct(Context $context,PageFactory $pageFactory){
		parent::__construct($context);
		$this->_resultPageFactory=$pageFactory;
	}
	public function execute(){
		$title = "Search transactions information";
		$resultPage=$this->_resultPageFactory->create();
		$resultPage->setActiveMenu("Bitcoin_Txs::txs");
		$resultPage->getConfig()->getTitle()->prepend(__($title));
		
		return $resultPage;
	}
}