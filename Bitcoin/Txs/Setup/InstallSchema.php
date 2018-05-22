<?php
namespace Bitcoin\Txs\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Db\Ddl\Table;

class InstallSchema implements InstallSchemaInterface{
	public function install(SchemaSetupInterface $setup,ModuleContextInterface $context){
		$setup->startSetup();
		$conn = $setup->getConnection();
		$tableName = $setup->getTable('txs');

		if($conn->isTableExists($tableName) != true){
			$table = $conn->newTable($tableName);
			$columns = [
				"id" => [
					"type" => Table::TYPE_INTEGER,
					"size" => null,
					"options" => [
						"identity" => true,
						"unsigned" => true,
						"nullable" => false,
						"primary" => true
					],
					"comment" => "ID"
				],

				"id_txs" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Transaction ID"
				],

				"addr_wallet" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Address Wallet"
				],

				"total_received" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Total bitcoin received"
				],

				"total_sent" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Total bitcoin sent"
				],

				"balance" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Balance wallet"
				],

				"type" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Send or receive"
				],

				"addr_sent" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => true
					],
					"comment" => "Send to Address"
				],

				"addr_received" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => true
					],
					"comment" => "Received from Address"
				],
				
				"value" => [
					"type" => Table::TYPE_TEXT,
					"size" => null,
					"options" => [
						"nullable" => false
					],
					"comment" => "Transaction value in BTC"
				],
			];

			foreach($columns as $column => $item){
				$table->addColumn(
					$column,
					$item['type'],
					$item['size'],
					$item['options'],
					$item['comment']
				);
			}

			$table->setOption('charset','utf8');
			$table->setOption('type','InnoDB');
			$conn->createTable($table);
		}
		$setup->endSetup();
	}
}