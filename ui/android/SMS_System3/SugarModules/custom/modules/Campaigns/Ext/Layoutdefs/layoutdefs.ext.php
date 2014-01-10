<?php
$layout_defs["Campaigns"]["subpanel_setup"]['campaigns_sms_sms'] = array(
					'order' => 30,
					'sort_order' => 'desc',
					'sort_by' => 'date_entered',
					'module' => 'SMS_SMS',
					'subpanel_name' => 'ForCampaigns',
					'get_subpanel_data' => 'campaigns_sms_sms',
					'title_key' => 'SMS',
					'top_buttons' => array(array('widget_class' => 'SubPanelTopSMSButton'))
				);
?>