<?php

// created: 2009-08-13 13:22:29
$layout_defs["Contacts"]["subpanel_setup"]["activities"]["collection_list"]['contacts_sms_sms'] = array(
					'module' => 'SMS_SMS',
					'subpanel_name' => 'default',
					'get_subpanel_data' => 'contacts_sms_sms',
				);

$layout_defs['Contacts']['subpanel_setup']['activities']['top_buttons'][(sizeof($layout_defs['Contacts']['subpanel_setup']['activities']['top_buttons'])+1)] = array('widget_class' => 'SubPanelTopSMSButton');

$layout_defs["Contacts"]["subpanel_setup"]["history"]["collection_list"]['contacts_sms_sms'] = array(
					'module' => 'SMS_SMS',
					'subpanel_name' => 'default_history',
					'get_subpanel_data' => 'contacts_sms_sms',					
				);				

$layout_defs['Contacts']['subpanel_setup']['history']['top_buttons'][(count($layout_defs['Contacts']['subpanel_setup']['history']['top_buttons']))] = array('widget_class' => 'SubPanelTopSMSButton');


?>
