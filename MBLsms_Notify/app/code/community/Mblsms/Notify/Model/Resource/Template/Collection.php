<?php
class Mblsms_Notify_Model_Resource_Template_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {  
        $this->_init('mblsms_notify/template');
    }  
}
