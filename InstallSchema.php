<?php
namespace vendor\module\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{

   
    
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        /**
         * Create table 'table1'
         */
        $table1 = $installer->getConnection()->newTable($installer->getTable('table1'))
            ->addColumn(
                'round_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
                'Entity ID'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'name'
            )
            ->addColumn(
                'weekday',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'weekday'
            )
            ->addColumn(
                'truck',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'truck'
            )
            
            ->addColumn(
                'time_span',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'time_span'
            )

	   ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                1,
                [],
                'status'
            )
            
            ->addIndex(
                $installer->getIdxName('eastlane_delivery_rounds', ['round_id']),
                ['round_id']
            )
            ->setComment('Delivery Rounds Table');    
        $installer->getConnection()->createTable($table1);
        
        /**
         * Create table 'table2'
         */

        $table2 = $installer->getConnection()->newTable($installer->getTable('table2'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
                'Entity ID'
            )
		
	   ->addColumn(
                'zipcode',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'zipcode'
            )
            ->addColumn(
                'round_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                1,
                ['nullable' => false,'unsigned' => true],
                'round_id'
            )
            
            ->addIndex(
                $installer->getIdxName('eastlane_delivery_rounds_zipcode', ['id']),
                ['id']
            )
            ->addForeignKey(
                $installer->getFkName('eastlane_delivery_rounds_zipcode', 'round_id', 'eastlane_delivery_rounds', 'round_id'),
                'round_id',
                $installer->getTable('eastlane_delivery_rounds'),
                'round_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Delivery rounds zipcode Table');
        $installer->getConnection()->createTable($table_eastlane_delivery_rounds_zipcode);
        
        /**
         * Create table 'table2'
         */
        
        $table3 = $installer->getConnection()->newTable($installer->getTable('table3'))
             ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
                'Entity ID'
            )

            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'store_id'
            )
            
            ->addColumn(
                'round_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                1,
                ['nullable' => false,'unsigned' => true],
                'round_id'
            )
            ->addForeignKey(
                $installer->getFkName('eastlane_delivery_rounds_store', 'round_id', 'eastlane_delivery_rounds', 'round_id'),
                'round_id',
                $installer->getTable('eastlane_delivery_rounds'),
                'round_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
                        
        
        $installer->getConnection()->createTable($table_eastlane_delivery_rounds_store);



	 $table4 = $installer->getConnection()->newTable($installer->getTable('table4'))
             ->addColumn(
                'restricted_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
                'Entity ID'
            	)
		->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'name'
            	)
           	 ->addColumn(
                'date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                [],
                'date'
            	)
		 ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                1,
                [],
                'status'
            );

        $installer->getConnection()->createTable($table4);

	
	 /**
         * add delivery_round Column to quote delivery_round  
         */


	    $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'delivery_round',
            [
                'type' => 'text',
                'nullable' => false,
                'comment' => 'Delivery Round',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'delivery_round',
            [
                'type' => 'text',
                'nullable' => false,
                'comment' => 'Delivery Round',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );




        $installer->endSetup();
    }
}
