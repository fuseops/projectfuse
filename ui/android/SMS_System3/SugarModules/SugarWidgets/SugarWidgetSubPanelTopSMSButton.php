<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * SugarWidgetSubPanelTopButton
 *
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
 */

// $Id$
echo '
<link rel="stylesheet" href="modules/SMS_SMS/javascript/lightbox/css/lightbox.css" media="screen,projection" type="text/css" />
<script src="modules/SMS_SMS/javascript/lightbox/scripts/prototype.js"></script>
<script src="modules/SMS_SMS/javascript/lightbox/scripts/lightbox.js"></script>';


require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelTopSMSButton extends SugarWidgetSubPanelTopButton
{
	
	function display($defines, $additionalFormFields = null)
	{
		$temp='';
		if(!empty($this->acl) && ACLController::moduleSupportsACL($defines['module'])  &&  !ACLController::checkAccess($defines['module'], $this->acl, true)){
			$button = "<input title='$this->title'  class='button' type='button' name='" . $this->getWidgetId() . "_create_button' value='  $this->form_value  ' disabled/>\n</form>";
			return $temp;
		}		
		global $app_strings;
		
		$button = '';
		
		if(isset($app_strings['LNK_NEW_SMS'])) {
			if($this->getWidgetId() == "Activities") {
				$button = "<div id='overlay'></div>
	      <div id='lbLoadMessage'></div>".$this->_get_form($defines, $additionalFormFields);
				$button .= "<a  href='index.php?action=EditView&module=SMS_SMS&parent_id=".$_REQUEST["record"]."&parent_type=".strtolower($_REQUEST["module"])."' style='text-decoration:none;' onClick='openDialogWindow(this,\"NotSent\");'><input title='$this->title' accesskey='$this->access_key' class='button lbOn' type='submit' name='" . $this->getWidgetId() . "_create_button' id='smsBtn' value='  $this->form_value  ' onclick='return false;' id='sendSMSBtn'/></a>\n			
	      </form>";
			} else {
				if($this->getWidgetId() == "campaigns_sms_sms") {
					$button = "<div id='overlay'></div>
	      <div id='lbLoadMessage'></div>".$this->_get_form($defines, $additionalFormFields);
					$button .= "<input type=hidden name='composeFrom' id='composeFrom' value='campaigns'><span name='" . $this->getWidgetId() . "_create_button' id='smsBtnHistory'  style='display:nonse;'/>&nbsp;</span><span name='" . $this->getWidgetId() . "_create_button2' id='smsBtn'  style='display:nonse;'/>&nbsp;</span>\n</form>";
				}
				else 
					$button = "<span name='" . $this->getWidgetId() . "_create_button' id='smsBtnHistory'  style='display:nonse;'/>&nbsp;</span>\n";
			}
		}
		return $button;
	}

	
	function &_get_form($defines, $additionalFormFields = null)
	{
		global $app_strings,$mod_strings;
		global $currentModule;

		$this->module="SMS_SMS";
		$this->subpanelDiv = "activities";
		$this->widget_class='SugarWidgetSubPanelTopSMSButton';
		$this->title=$app_strings['LBL_NEW_BUTTON_TITLE'];
		$this->access_key=$app_strings['LBL_NEW_BUTTON_KEY'];
		$this->form_value=$app_strings['LNK_NEW_SMS'];
		$this->ACL='edit';
//echo "<pre>";print_r($app_strings);
		// Create the additional form fields with real values if they were not passed in
		if(empty($additionalFormFields) && $this->additional_form_fields)
		{
			foreach($this->additional_form_fields as $key=>$value)
			{
				if(!empty($defines['focus']->$value))
				{
					$additionalFormFields[$key] = $defines['focus']->$value;
				}
				else
				{
					$additionalFormFields[$key] = '';
				}
			}
		}
		
		if(!empty($this->module))
		{
			$defines['child_module_name'] = $this->module;
		}
		else
		{
			$defines['child_module_name'] = $defines['module'];
		}

		if(!empty($this->subpanelDiv))
		{
			$defines['subpanelDiv'] = $this->subpanelDiv;
		}

		$defines['parent_bean_name'] = get_class( $defines['focus']);

		$form = 'form' . $defines['child_module_name'];
		$button = '<form onsubmit="return SUGAR.subpanelUtils.sendAndRetrieve(this.id, \'subpanel_' . strtolower($defines['subpanelDiv']) . '\', \'' . addslashes($app_strings['LBL_LOADING']) . '\', \'' . strtolower($defines['subpanelDiv']) . '\');" action="index.php" method="post" name="form" id="form' . $form . "\">\n";

		//module_button is used to override the value of module name
		$button .= "<input type='hidden' name='target_module' value='".$defines['child_module_name']."'>\n";
		$button .= "<input type='hidden' name='".strtolower($defines['parent_bean_name'])."_id' value='".$defines['focus']->id."'>\n";

		if(isset($defines['focus']->name))
		{
			$button .= "<input type='hidden' name='".strtolower($defines['parent_bean_name'])."_name' value='".$defines['focus']->name."'>";
		}

		$button .= '<input type="hidden" name="to_pdf" value="true" />';
        $button .= '<input type="hidden" name="tpl" value="QuickCreate.tpl" />';
		$button .= '<input type="hidden" name="return_module" value="' . $currentModule . "\" />\n";
		$button .= '<input type="hidden" name="return_action" value="' . $defines['action'] . "\" />\n";
		$button .= '<input type="hidden" name="return_id" value="' . $defines['focus']->id . "\" />\n";
		 
		// TODO: move this out and get $additionalFormFields working properly
		if(empty($additionalFormFields['parent_type']))
		{
			if($defines['focus']->object_name=='Contact') {
				$additionalFormFields['parent_type'] = 'Accounts';
			}
			else {
				$additionalFormFields['parent_type'] = $defines['focus']->module_dir;
			}
		}
		if(empty($additionalFormFields['parent_name']))
		{
			if($defines['focus']->object_name=='Contact') {
				$additionalFormFields['parent_name'] = $defines['focus']->account_name;
				$additionalFormFields['account_name'] = $defines['focus']->account_name;
			}
			else {
				$additionalFormFields['parent_name'] = $defines['focus']->name;
			}
		}
		if(empty($additionalFormFields['parent_id']))
		{
			if($defines['focus']->object_name=='Contact') {
				$additionalFormFields['parent_id'] = $defines['focus']->account_id;
				$additionalFormFields['account_id'] = $defines['focus']->account_id;
			}
			else {
				$additionalFormFields['parent_id'] = $defines['focus']->id;
			}
		}

		$button .= '<input type="hidden" name="action" value="SubpanelCreates" />' . "\n";
		$button .= '<input type="hidden" name="module" value="Home" />' . "\n";
		$button .= '<input type="hidden" name="target_action" value="EditView" />' . "\n";
		
		// fill in additional form fields for all but action
		foreach($additionalFormFields as $key => $value)
		{
			if($key != 'action')
			{
				$button .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
			}
		}
		$button .='<script type="text/javascript" src="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"></script>'."\n";
		return $button;
	}	
}
?>
