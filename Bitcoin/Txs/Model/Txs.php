<?php
namespace Bitcoin\Txs\Model;
class Txs extends \Magento\Framework\Model\AbstractModel{
	protected function _construct(){
		$this->_init("Bitcoin\Txs\Model\ResourceModel\Txs");
	}
}