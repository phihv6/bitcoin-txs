<?php
namespace Bitcoin\Txs\Model\ResourceModel\Txs;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
	protected $_idFieldName="id";
	protected function _construct(){
		$this->_init("Bitcoin\Txs\Model\Txs","Bitcoin\Txs\Model\ResourceModel\Txs");
	}
}