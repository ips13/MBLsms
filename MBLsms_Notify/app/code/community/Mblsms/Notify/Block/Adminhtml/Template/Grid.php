<?php

class Mblsms_Notify_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        // Set some defaults for our grid
        $this->setDefaultSort('id');
        $this->setId('mblsms_notify_template_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'mblsms_notify/template_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }
     
    protected function _prepareColumns()
    {
        // Add the columns that should appear in the grid
        $this->addColumn(
            'id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );
         
        $this->addColumn(
            'name',
            array(
                'header'=> $this->__('Name'),
                'index' => 'name'
            )
        );
        
        $this->addColumn(
            'order_status',
            array(
                'header'=> $this->__('Order Status'),
                'index' => 'order_status',
                'type'     => 'options',
                'options' => Mblsms_Notify_Block_Adminhtml_Template_Grid::getOrderOptionArray()
            )
        );
        $this->addColumn(
            'enable_disable',
            array(
                'header'=> $this->__('Status'),
                'index' => 'enable_disable',
                'type'     => 'options',
                'options' => array(
                    0    => 'Disabled',
                    1    => 'Enabled'
                )
            )
        );
         
        return parent::_prepareColumns();
    }
     
    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    static public function getOptionArray4()
    {
        $dataArray        = array(); 
        $dataArray[0]    = 'Disable';
        $dataArray[1]    = 'Enable';
        return($dataArray);
    }
    
    static public function getValueArray4()
    {
        $dataArray=array();
        foreach (Mblsms_Notify_Block_Adminhtml_Template_Grid::getOptionArray4() as $k=>$v) {
            $dataArray[]=array('value'=>$k,'label'=>$v); 
        }

        return($dataArray);

    }
    
    static public function getOrderOptionArray()
    {
        $dataArray=array(); 
        $dataArray['pending']        = 'New';
        $dataArray['processing']    = 'Processing';
        $dataArray['complete']        = 'Complete';
        $dataArray['closed']        = 'Closed';
        $dataArray['canceled']        = 'Canceled';
        $dataArray['holded']        = 'On Hold';        
        return($dataArray);
    }
    
    static public function getOrderValueArray()
    {
        $dataArray=array();
        foreach (Mblsms_Notify_Block_Adminhtml_Template_Grid::getOrderOptionArray() as $k=>$v) {
            $dataArray[]=array('value'=>$k,'label'=>$v); 
        }

        return($dataArray);

    }
}
