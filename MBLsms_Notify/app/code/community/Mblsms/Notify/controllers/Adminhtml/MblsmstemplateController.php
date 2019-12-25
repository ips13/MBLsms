<?php
class Mblsms_Notify_Adminhtml_MblsmstemplateController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {  
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()->renderLayout();
    }  
     
    public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }  
     
    public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('mblsms_notify/template');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This template no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New Template'));
     
        $data = Mage::getSingleton('adminhtml/session')->getTemplateData(true);
        if (!empty($data)) {
            $model->setData($data);
        }  
     
        Mage::register('mblsms_notify', $model);
        $breadcrumb = ($id) ? $this->__('Edit Template') : $this->__('New Template');
        $adminEditTpl = $this->getLayout()->createBlock('mblsms_notify/adminhtml_template_edit');

        $this->_initAction()
            ->_addBreadcrumb($breadcrumb)
            ->_addContent($adminEditTpl->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
     
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('mblsms_notify/template');
            $model->setData($postData);
 
            try {
                $model->save();
 
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The template has been saved.'));
                $this->_redirect('*/*/');
 
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                $errMsg = $this->__('An error occurred while saving this template.');
                Mage::getSingleton('adminhtml/session')->addError($errMsg);
            }
 
            Mage::getSingleton('adminhtml/session')->setTemplateData($postData);
            $this->_redirectReferer();
        }
    }
    
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('mblsms_notify/template');
                 
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                $succMsg = Mage::helper('adminhtml')->__('Item was successfully deleted');
                Mage::getSingleton('adminhtml/session')->addSuccess($succMsg);

                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/');        
    }

    /**
     * Method used for testing to display message content
     */
    public function messageAction()
    {
        $data = Mage::getModel('mblsms_notify/template')->load($this->getRequest()->getParam('id'));
        return $data->getContent();
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('cms/mblsms_notify_template')
            ->_title($this->__('Sales'))->_title($this->__('MBLSMS Template'))
            ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
            ->_addBreadcrumb($this->__('MBLSMS Template'), $this->__('MBLSMS Template'));
         
        return $this;
    }
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/mblsms_notify_template');
    }
    
}
