<?php
namespace Bitcoin\Txs\Block\Adminhtml\Txs;
use Magento\Backend\Block\Widget\Form\Container;
class Search extends Container{
	protected function _construct(){
		$this->_blockGroup="Bitcoin_Txs";
		$this->_controller="Adminhtml_txs";
		$this->_objectId="id";
		parent::_construct();

		$this->buttonList->update("save","label",__("Search"));
		
	}
}