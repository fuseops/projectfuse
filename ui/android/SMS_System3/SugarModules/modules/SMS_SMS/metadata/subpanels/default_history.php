<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Subpanel Layout definition for Contacts
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

$subpanel_layout = array(
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopCreateButton'),
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'SMS_SMS'),
	),

	'where' => "sms_sms.status ='Sent'",
		

	'list_fields' => array(
		'object_image'=>array(
			'vname' => 'LBL_OBJECT_IMAGE',
			'widget_class' => 'SubPanelSMSIcon',
 		 	'width' => '2%',
		),
		'name'=>array(
			'name'=>'name',		
			'vname' => 'LBL_LIST_NAME',            
			'width' => '23%',
			'widget_class' => 'SubPanelSMSDetailViewLink',
		),
		'status'=>array(
			'name'=>'status',		
			'vname' => 'LBL_LIST_NAME1',            
			'width' => '23%',
		),
			
		'contact_name'=>array(
			//'usage'=>'query_only',
			'force_exists'=>true,
			
		),
		'contact_name_owner'=>array(
			'usage'=>'query_only',
			'force_exists'=>true
			),	
		'contact_name_mod'=>array(
			'usage'=>'query_only',
			'force_exists'=>true
			),	
		'account_id'=>array(
			'usage'=>'query_only',
			'force_exists'=>true
		),
		'dummyColumn11'=>array(			
			'usage'=>'query_only',
			'force_exists'=>true
		),
		'dummyColumn121'=>array(			
			'usage'=>'query_only',
			'force_exists'=>true
		),
		'dummyColumn131'=>array(			
			'usage'=>'query_only',
			'force_exists'=>true,
			'width' => '5%',
		),
		'dummyColumn13s1'=>array(			
			'usage'=>'query_only',
			'width' => '5%',
		),
		'date_entered'=>array(
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_SENT',
			'alias' => 'date_entered',
			'sort_by' => 'date_entered',			
			'width' => '5%',
		),	
		'to_user_id'=>array(
			'name' => 'to_user_id',
			'vname' => 'LBL_TO',
			'alias' => 'assigned_user_name',			
			'width' => '5%',
		),

		'edit_button'=>array(
			 'width' => '2%',
			 'widget_class' => 'SubPanelSMSEditButton',
		),		
		'remove_button'=>array(
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'Contacts',
			'width' => '5%',
		),
	),
);		
?>
