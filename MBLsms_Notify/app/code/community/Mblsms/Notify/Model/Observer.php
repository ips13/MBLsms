<?php

class Mblsms_Notify_Model_Observer
{
    public function checkOrderStatus($observer)
    {   
        $order = $observer->getEvent()->getOrder();
        $mblsmsHelper = Mage::helper('mblsms_notify/data');
        
        $shipPhone = $order->getShippingAddress()->getTelephone();
        $billPhone = $order->getBillingAddress()->getTelephone();
        $phone = (!empty($billPhone))? $billPhone : $shipPhone ;
        
        //if new order placed
        if (($order->getState() == Mage_Sales_Model_Order::STATE_NEW) || ($order->getStatus() == "pending")) {
            $smsTemplate = $this->get_template('pending');
        }    
        
        //if order in processing
        if (($order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING) || ($order->getStatus() == "processing")) {
            $smsTemplate = $this->get_template('processing');
        }
        
        //if order completed
        if (($order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE) || ($order->getStatus() == "complete")) {
            $smsTemplate = $this->get_template('complete');
        }
        
        //if order closed
        if (($order->getState() == Mage_Sales_Model_Order::STATE_CLOSED) || ($order->getStatus() == "closed")) {
            $smsTemplate = $this->get_template('closed');
        }
        
        //if order cancelled
        if (($order->getState() == Mage_Sales_Model_Order::STATE_CANCELED) || ($order->getStatus() == "canceled")) {
            $smsTemplate = $this->get_template('canceled');
        }
        
        //if order status Hold
        if (($order->getState() == Mage_Sales_Model_Order::STATE_HOLDED) || ($order->getStatus() == "holded")) {
            $smsTemplate = $this->get_template('holded');
        }
        
        //parse message and send message in API
        if (isset($smsTemplate) && !empty($smsTemplate)) {
            $message = $this->parseMessage($smsTemplate, $order);
            if (!empty($phone)) {
                $result  = $mblsmsHelper->sendSms($phone, $message);
            } else {
                $message = 'Mobile Number not found';
            }

            $this->logdata($order, $message);
        }
        
        return;
    }
    
    //get template
    public function get_template($status)
    {
        $smsTemplate = '';
        $collection = Mage::getModel('mblsms_notify/template')->getCollection()
                ->addFieldToSelect('tpl_content')
                ->addFieldToFilter('order_status', $status)
                ->addFieldToFilter('enable_disable', 1);
                foreach ($collection as $data) {
                    $smsTemplate = Mage::helper('cms')->getPageTemplateProcessor()
                    ->filter($data->getData('tpl_content'));
                }

        return $smsTemplate;
    }
    
    //parse message and replace placeholders
    public function parseMessage($message,$order)
    {
        
        //get all items from order
        $items         = $order->getAllVisibleItems();
        $productIds = array();
        $productNames = array();
        foreach ($items as $item) {
            $productIds[]     = $item->getId();
            $productNames[] = $item->getName();
        }

        $allProductNames = implode(',', $productNames);
        
        $placeholders = array(
            '{{orderid}}',
            '{{customer_name}}',
            '{{customer_email}}',
            '{{phone_no}}',
            '{{order_details}}',
            '{{order_quantity}}',
            '{{order_amount}}'
        );
        
        $replacewith = array(
            $order->getIncrementId(),
            $order->getCustomerName(),
            $order->getCustomerEmail(),
            $order->getShippingAddress()->getTelephone(),
            $allProductNames,
            $order->getTotalQtyOrdered(),
            $order->getGrandTotal()
        );
        
        $message = str_replace($placeholders, $replacewith, $message);
        return $message;
    }
    
    //log data into file when message send
    public function logdata($order,$message)
    {
        $content = 'ID:'.$order->getIncrementId().' Status:'.$order->getStatus().' Content:'.$message;
        Mage::log($content, null, 'ordercontent.log', true);
    }
    
}
