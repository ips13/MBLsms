<?php

class Mblsms_Notify_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'mblsms_notify';
        $this->_controller = 'adminhtml_template';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save Template'));
        $this->_updateButton('delete', 'label', $this->__('Delete Template'));
    } 
    protected function _prepareLayout() 
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        }
    }
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('mblsms_notify')->getId()) {
            return $this->__('Edit Template');
        } else {
            return $this->__('New Template');
        }  
    }  
}
