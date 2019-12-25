<?php

/**
 * @var $installer mblsms_notify_template
 *
 * Create table 'mblsms_notify/template'
 */
$installer = $this;
$installer->startSetup();

if (!$installer->getConnection()->isTableExists('mblsms_notify/template')) {
    $mblsmsTable = $installer->getTable('mblsms_notify/template');
    $table = $installer->getConnection()
       ->newTable($mblsmsTable)
       ->addColumn(
           'id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
            ), 'ID'
       )
        ->addColumn(
            'order_status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
            'default' => '', 
            ), 'Order Status'
        )
        ->addColumn(
            'name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
            'default' => '',
            ), 'Name'
        )
        ->addColumn(
            'subject', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
            'default' => '',
            ), 'Subject'
        )
        ->addColumn(
            'tpl_content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
            'default' => '',
            ), 'Content'
        )
        ->addColumn(
            'enable_disable', Varien_Db_Ddl_Table::TYPE_TINYINT, 2, array(
            'nullable' => false,
            'default' => '0',
            ), 'Enable Disable'
        )
        ->addColumn(
            'created_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
            'default' => null,
            ), 'Created Date'
        )
        ->addIndex(
            $installer->getIdxName($mblsmsTable, array('id')),
            array('id')
        )
        ->setComment('MBLSMS Templates table');
        $installer->getConnection()->createTable($table);
}

$installer->endSetup();