<?php
class Mblsms_Notify_Block_Adminhtml_Template extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        // The blockGroup must match the first half of how we call the block, and controller matches the second half
        // ie. mblsms_notify/adminhtml_template
        $this->_blockGroup = 'mblsms_notify';
        $this->_controller = 'adminhtml_template';
        $this->_headerText = $this->__('MBLSMS Template');
         
        parent::__construct();
    }
}
