<?php

/**
 * @var $installer mblsms_notify_template
 *
 * Create table 'mblsms_notify/template'
 */
$installer = $this;
$installer->startSetup();

$templates = array(
    array(
        'order_status'     => 'pending',
        'name'             => 'New Order Tpl.',
        'tpl_content'     => 'OrderID: {{orderid}}\r\n<p>Name: {{customer_name}}</p>\r\n
							<p>Email: {{customer_email}}</p>\r\n
							<p>Phone:{{phone_no}}</p>\r\n
							<p>Details:{{order_details}}</p>\r\n
							<p>Quantity:{{order_quantity}}</p>\r\n
							<p>Amount:{{order_amount}}</p>',
        'enable_disable'=> 1,
        'created_time'    => '2018-01-30 16:39:09'
    ),
    array(
        'order_status'     => 'processing',
        'name'             => 'Order Processing Tpl.',
        'tpl_content'     => '<p>Hello This is <b>Processing Order</b> Template</p>',
        'enable_disable'=> 1,
        'created_time'    => '2018-01-30 16:39:09'
    )
);

//save template content in database
foreach ($templates as $template) {
    $installer->getConnection()
    ->insertForce($installer->getTable('mblsms_notify/template'), $template);
}

$installer->endSetup();
