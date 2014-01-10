<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
/*********************************************************************************

 * Description: 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
require_once('XTemplate/xtpl.php');
require_once('modules/SMS_SMS/SMS_SMS.php');

global $app_strings;
global $mod_strings;
global $app_list_strings;
global $current_language;
global $current_user;
global $urlPrefix;
global $currentModule;
//echo "<pre>";print_r($_REQUEST);
$current_module_strings = return_module_language($current_language, 'SMS_SMS');
echo "\n<p>\n";


echo get_module_title('Campaigns', $current_module_strings['LNK_NEW_SMS'], false);
echo "\n</p>\n";
global $theme;

$focus = new SMS_SMS();
if(isset($_REQUEST['record']))
{
	if (isset($_REQUEST['record'])) $campaign_id = $_REQUEST['record'];
}

$xtpl=new XTemplate ('modules/Campaigns/SendSMS.html');
$xtpl->assign("MOD", $current_module_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("RETURN_MODULE",$_POST['return_module']);
$xtpl->assign("RETURN_ACTION",$_POST['return_action']);
$xtpl->assign("RETURN_ID",$_POST['record']);

	
	$query = "SELECT plp.*,  
			CASE  related_type 
				WHEN 'Prospects'  then (SELECT concat(COALESCE(first_name,''), ' ', last_name) from prospects 
										WHERE prospects.id= plp.related_id and prospects.deleted=0) 
				WHEN 'Contacts'  then (SELECT concat(COALESCE(first_name,''), ' ', last_name) from contacts 
										WHERE contacts.id= plp.related_id and contacts.deleted=0) 
				WHEN 'Leads'  then (SELECT concat(COALESCE(first_name,''), ' ', last_name) from leads 
									WHERE leads.id= plp.related_id and leads.deleted=0) 	
				WHEN 'Users'  then (SELECT concat(COALESCE(first_name,''), ' ', last_name) from users 
									WHERE users.id= plp.related_id and users.deleted=0)
				WHEN 'Accounts'  then (SELECT concat(COALESCE(name,''), '') from accounts 
									WHERE accounts.id= plp.related_id and accounts.deleted=0) 										 	
			END   as senderName 
			FROM prospect_list_campaigns plc, prospect_lists_prospects plp 
			WHERE  plp.prospect_list_id = plc.prospect_list_id 
			AND plp.deleted=0 AND plc.deleted=0 AND plc.campaign_id='$campaign_id'";
		
		
		$seed=array();
	
		$result=$focus->db->query($query);
		while(($row=$focus->db->fetchByAssoc($result)) != null) {
			$toOptions = "<select name=\"sendToNameFld_".$row['related_id']."\" id=\"sendToNameFld_".$row['related_id']."\">";
			
			$toOptions .= getRecipientData($row['related_id'], $row['related_type'], '');
			
			$toOptions .= '</select>';
			
			$display_fields = array(
				'ID'			=> $row['id'],
				'related_id'			=> $row['related_id'],
				'related_type'			=> ucwords($row['related_type']),				
				'senderName'	=> $row['senderName'],
				'senderContactNumber'	=> $toOptions,
			);
			
			$xtpl->assign("CAMPAIGNENTRY", $display_fields);			
			$xtpl->parse('main.row');			
		}
		$xtpl->parse("main");
		$xtpl->out("main");
?>