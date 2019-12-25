<?php

class Mblsms_Notify_Block_Adminhtml_Template_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('mblsms_notify_template_form');
        $this->setTitle($this->__('MBLSMS Template Information'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
        $model = Mage::registry('mblsms_notify');
        $config = array(
            'add_variables'        => true,
            'add_widgets'        => false,
            'add_directives'    => true,
            'use_container'        => true,
            'container_class'    => 'hor-scroll'
        );
        
        $form = new Varien_Data_Form(
            array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
            )
        );
     
        $fieldset = $form->addFieldset(
            'base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('SMS Template Information'),
            'class'     => 'fieldset-wide',
            )
        );
     
        if ($model->getId()) {
            $fieldset->addField(
                'id', 'hidden', array(
                'name' => 'id',
                )
            );
        }  
     
        $fieldset->addField(
            'name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('checkout')->__('Name'),
            'title'     => Mage::helper('checkout')->__('Name'),
            'required'  => true,
            )
        );
        
        $fieldset->addField(
            'order_status', 'select', array(
            'name'  => 'order_status',
            'label' => Mage::helper('checkout')->__('Order Status'),
            'values'   => Mblsms_Notify_Block_Adminhtml_Template_Grid::getOrderValueArray()
            )
        );
        
        //editor use removed
        $fieldset->addField(
            'tpl_content', 'textarea', array(
            'name'      => 'tpl_content',
            'label'     => Mage::helper('checkout')->__('Content'),
            'title'     => Mage::helper('checkout')->__('Content'),
            'style'     => 'height:15em',
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig($config),
            'wysiwyg'   => true,
            'required'  => false,
            )
        );
        
        $fieldset->addField(
            'enable_disable', 'select', array(
            'name'  => 'enable_disable',
            'label' => Mage::helper('checkout')->__('Enable/Disable'),
            'values'   => Mblsms_Notify_Block_Adminhtml_Template_Grid::getValueArray4()
            )
        );
     
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }
    
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
}
