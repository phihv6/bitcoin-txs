<?php
namespace Bitcoin\Txs\Controller\Adminhtml\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Bitcoin\Txs\Model\TxsFactory;
use Magento\Framework\Registry;
class Save extends \Magento\Backend\App\Action{
	protected $_resultPageFactory;
	protected $_txsFactory;
	protected $_coreRegistry;
	public function __construct(Context $context, PageFactory $pageFactory, TxsFactory $txsFactory,Registry $registry){
		parent::__construct($context);
		$this->_resultPageFactory=$pageFactory;
		$this->_txsFactory = $txsFactory;
		$this->_coreRegistry = $registry;
	}
	public function execute(){
		GLOBAL $walletAddress,$totalReceived,$totalSent,$balance,$type,$addressReceived,$addressSent,$val,$limit,$json;

		$request = $this->getRequest();
		$formData = $request->getPostValue();
		$txsModel = $this->_txsFactory->create();

		//get address and limit from post data
		$address = $formData['id'];
		if(isset($formData['limit'])){
			if(intval($formData['limit'])!=0){
				$limit = '?&limit='. intval($formData['limit']);
			}else
				$limit = '?&limit=50';
		}else
			$limit = '?&limit=50';

		$url = 'https://blockchain.info/vi/rawaddr/'.$address.$limit;
		
		try{
			$json = file_get_contents($url);
		}catch(\Exception $e){
			$this->messageManager->addError(__("You entered the wrong wallet address: ".$address." , please check and try again"));
			return $this->_redirect("*/*/search");			
		}
		$obj = json_decode($json);

		//convert stdClass elements of $obj to array
		for($i=0;$i<count($obj->txs);$i++){
			for($j=0;$j<count($obj->txs[$i]->inputs);$j++){
				for($k=0;$k<count($obj->txs[$i]->inputs[$j]);$k++){
					$obj->txs[$i]->inputs[$j]->prev_out = get_object_vars($obj->txs[$i]->inputs[$j]->prev_out);
				}
				$obj->txs[$i]->inputs[$j] = get_object_vars($obj->txs[$i]->inputs[$j]);	
			}
			for($m=0;$m<count($obj->txs[$i]->out);$m++){
				$obj->txs[$i]->out[$m] = get_object_vars($obj->txs[$i]->out[$m]);
			}
			$obj->txs[$i] =get_object_vars($obj->txs[$i]);
		}

		if(empty($obj->txs)){
			$limit ='';
			$this->messageManager->addNotice(__("Can not find any transactions for this address: ".$address.", please fill in another address"));
			return $this->_redirect("*/*/search");
		}else{

			$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
			$table = $resource->getTableName('txs');
			$row = $resource->getConnection()->delete($table,[1]);
			
			//update data
			$walletAddress =  $obj->address;
			$totalReceived = $obj->total_received;
			$totalSent = $obj->total_sent;
			$balance =  $obj->final_balance;
			
			foreach($obj->txs as $key => $value0){
					$idTransaction = $key;
					foreach($value0 as $key1=>$value1){
						if($key1=='inputs'){
							foreach($value1 as $key2 => $value2){
								 $type = $key1;
								foreach($value2 as $key3 => $value3){
									if($key3=='prev_out'){
										foreach($value3 as $key4 => $value4){
											if($key4=='addr')
												 $addressReceived = $value4;
											if($key4=='value')
												 $val = $value4;
										}
										if($val!=''){
											$txsModel = $this->_objectManager->create("Bitcoin\Txs\Model\Txs");
											$txsModel->addData([
												"id_txs" => $idTransaction,
												"addr_wallet" => $walletAddress,
												"total_received" => $totalReceived,
												"total_sent" => $totalSent,
												"balance" => $balance,
												"type" => $type,
												"addr_sent" => '',
												"addr_received" => $addressReceived,
												"value" => $val
											])->save();
											$addressReceived='';
											$val='';
											break;
										}	
										
									}
										
								}
							}
						}

						if($key1=='out'){
							foreach($value1 as $key2 => $value2){
								$type = $key1;
								foreach($value2 as $key3 => $value3){
									if($key3=='addr')
										$addressSent = $value3;
									if($key3=='value')
										$val = $value3;
									if($val!=''){
										$txsModel = $this->_objectManager->create("Bitcoin\Txs\Model\Txs");
										$txsModel->addData([
											"id_txs" => $idTransaction,
											"addr_wallet" => $walletAddress,
											"total_received" => $totalReceived,
											"total_sent" => $totalSent,
											"balance" => $balance,
											"type" => $type,
											"addr_sent" => $addressSent,
											"addr_received" => '',
											"value" => $val
										])->save();
										$addressSent='';
										$val='';
										break;
									}
								
								}
								
							}
						}
						
					}
			}
		}
		$limit='';
		$this->messageManager->addSuccess(__("The transactions have been updated"));
		return $this->_redirect("*/*/");	
		
	}
}