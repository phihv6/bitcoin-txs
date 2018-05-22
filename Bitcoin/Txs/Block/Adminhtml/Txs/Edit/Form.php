<?php
namespace Bitcoin\Txs\Block\Adminhtml\Txs\Edit;
use Magento\Backend\Block\Widget\Form\Generic;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
class Form extends Generic{
	public function __construct(Context $context,Registry $registry,FormFactory $formfactory,array $data){
		parent::__construct($context,$registry,$formfactory,$data);
	}
	protected function _construct(){
		$this->setId("txs_form");
		$this->setTitle(__("Transaction Information"));
		parent::_construct();
	}
	protected function _prepareForm(){
		$model = $this->_coreRegistry->registry("txs");
		$form= $this->_formFactory->create(
				[
					"data" =>[
						"id" => "edit_form",
						"action" => $this->getData("action"),
						"method" =>"post",
					]
				]
			);
		$fieldset=$form->addFieldset(
				"base_fieldset",
				[
					"legend"=>__("General Information"),
					"class"=>"fieldset-wide"
				]
			);
		$fieldset->addField(
				"id",
				"text",
				[
					"name" => "id",
					"label" => __("Wallet address"),
					"required" => true,
					"placeholder" => "Paste wallet address to get transactions information into this field..."
				]
			);
		
		$fieldset->addField(
			"limit",
			"text",
			[
				"name" => "limit",
				"label" => __("Limit"),
				"required" => false,
				"placeholder" => "Number of transactions you want take (default is 50)"
			]
		);
		
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}

  ?>