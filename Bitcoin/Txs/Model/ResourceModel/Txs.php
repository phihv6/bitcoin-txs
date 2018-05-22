<?php
namespace Bitcoin\Txs\Model\ResourceModel;
class Txs extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
	protected function _construct(){
		$this->_init("txs","id");
	}
}