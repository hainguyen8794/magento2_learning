<?php
namespace Robin\Bai1\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
       $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable('banner');
       /* $installer->getConnection()->addColumn($tableName, 'sort_order', [
            'type' => Table::TYPE_INTEGER,
            'nullable' => true,
            'comment' => 'Sort order banner ?'
        ]);*/
        $installer->getConnection()->addColumn($tableName, 'sort_order', [
            'type' => Table::TYPE_SMALLINT,
            'nullable' => true,
            'comment' =>'Sort order banner ?'
        ]);
        $installer->endSetup();
       /* $setup->startSetup();
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('banner');
        $connection->addIndex(
            $tableName,
            'search',
            [
                'image',
                'link'
            ],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );
        $setup->endSetup();*/
    }


}