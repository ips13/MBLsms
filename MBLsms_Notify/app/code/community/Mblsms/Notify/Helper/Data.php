<?php

class Mblsms_Notify_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    public $appName = 'Mblsms_Notify';

    // This method simply returns an array of all the extension specific settings
    public function getSettings()
    {
        // Create an empty array
        $settings = array();

        // Get the Mblsms settings
        $settings['mblsms_sendfrom']         = Mage::getStoreConfig('mblsms/mblsms_config/sendfrom');
        $settings['mblsms_mobile_code']     = Mage::getStoreConfig('mblsms/mblsms_config/mobile_code');
        $settings['mblsms_auth_token']         = Mage::getStoreConfig('mblsms/mblsms_config/auth_token');
        
        // Return the settings
        return $settings;
    }

    // This method sends the specified message to the specified recipients
    public function sendSms($recipient,$body)
    {
        // Get the settings
        $settings     = $this->getSettings();
        $mobileCode = $settings['mblsms_mobile_code'];
        
        $errors = array();
        
        $recipient = ltrim($recipient, '0');
        
        $postfields = array(
            'from'         => $settings['mblsms_sendfrom'],
            'mobileTo'     => $mobileCode.$recipient,
            'text'         => $body
        );
        $response = $this->mblsms_sendmsg($postfields);
        
        //if response has some errors
        if ($response['success'] == 0) {
            $errors[] = $response['data'];
        }

        // Check if any errors have occured
        if (!empty($errors)) {
            // Log the errors
            $this->log('Unable to send sms via MBLSMS: ' . Zend_Debug::dump($errors, null, false));
            return false;
        } else {
            $this->log('SMS sent: ' . Zend_Debug::dump($postfields, null, false));
            return true;
        }
    }
    
    /*
	 * Send message from MBLSMS APi
	 */
    public function mblsms_sendmsg($postfields)
    {
        $settings    = $this->getSettings();
        $apiKey      = $settings['mblsms_auth_token'];
        $postString = json_encode($postfields);
        
        $headers = array(
            "authorization: Basic {$apiKey}",
            "cache-control: no-cache",
            "Content-Type: application/json"
        );
        $curl = new Varien_Http_Client();
        $curl->setUri('https://rest.mblsms.com/api/sms/singlesms')
            ->setMethod('POST')
            ->setConfig(
                array(
                    'maxredirects'  =>    0,
                    'timeout'       =>    30
                )
            );
        $curl->setHeaders($headers);
        $curl->setRawData($postString, "application/json;charset=UTF-8");
        $response = $curl->request();
        
        if (!empty($response)) {
            $responseBody = Zend_Http_Response::extractBody($response);
            $this->logresponse($responseBody);

            $responseArr = json_decode($responseBody);
            if (isset($responseArr) && is_array($responseArr)) {
                return array('success'=>0,'data'=> $responseArr['Message']);
            }
            
            return array('success'=>1,'data'=> $responseBody);
        }

        return array('success'=>0,'data'=> 'Response not parsed');
    }

    // This method creates a log entry in the extension specific log file
    public function log($msg)
    {
        Mage::log($msg, null, 'mblsms_smsnotification.log', true);
    }
    
    //log mblsms response
    public function logresponse($msg)
    {
        Mage::log($msg, null, 'mblsms_response.log', true);
    }
}
