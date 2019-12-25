<?php

class Mblsms_Notify_Block_Adminhtml_System_Config_Info extends Mage_Adminhtml_Block_Abstract 
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Render Information element
     *
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setClass('mblsms-settings');
        $html = "<img src='https://mblsms.com/images/color_logo_transparent2x.png' width='100px'>";
        $html .= "<p>Thank you for using MBLSMS gateway to notify your customers.
					To obtain Auth Token, please register on
					<a href='https://www.mblsms.com' target='_blank'>https://www.mblsms.com</a>
					If you experience any problems, please contact our support department by sending an e-mail to
					<a href='mailto:support@mblsms.com'>support@mblsms.com</a>
				 </p>";
        return $html;
    }
}
