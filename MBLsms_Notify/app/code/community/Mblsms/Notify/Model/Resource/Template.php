<?php
class Mblsms_Notify_Model_Resource_Template extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('mblsms_notify/template', 'id');
    }  
}
