<?php
//Logic Hook Customization for saving the SMS information
class saveSMSInfo  {	
	function saveSMSInfo(&$bean, $event, $arguments)
	{
		//BEGIN: SMS Integration getting the apikey and apipassword    
	    if(isset($_POST['SMSAPIKEY'])) {
			$bean->setPreference('SMSAPIKEY',$_POST['SMSAPIKEY'], 0, 'global', $bean);
		} else {
			$bean->setPreference('SMSAPIKEY','', 0, 'global', $bean);
		}
	    if(isset($_POST['SMSAPIPASSWORD'])) {
			$bean->setPreference('SMSAPIPASSWORD',$_POST['SMSAPIPASSWORD'], 0, 'global', $bean);
		} else {
			$bean->setPreference('SMSAPIPASSWORD','', 0, 'global', $bean);
		}
		//END: SMS Integration getting the apikey and apipassword
	}	
}
?>