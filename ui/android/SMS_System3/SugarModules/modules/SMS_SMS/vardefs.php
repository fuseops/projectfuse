<?php
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
$dictionary['SMS_SMS'] = array(
	'table'=>'sms_sms',
	'audited'=>false,
	'fields'=>array (
'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_SUBJECT',
    'type' => 'text',
   // 'dbType' => 'varchar',
    //'len' => '160',
    'comment' => 'SMS Message',
    'importable' => 'required',
  ),
  'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_SENT',
    'type' => 'datetime',
   // 'dbType' => 'varchar',
    //'len' => '160',
    'comment' => 'SMS Message',
    'importable' => 'required',
  ),

  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    //'type' => 'enum',
    //'len' => '25',
    //'options' => 'sms_status_dom',
	'type' => 'varchar',
        'function' => array(
            'name' => 'getStatusOpions',
            'returns' => 'html',
            'include' => 'modules/SMS_SMS/SMSFunctions.php'
        ) ,
		'len' => '20',      
    'comment' => 'SMS status (ex: Planned, Held, Not held)'
  ),
	'sender_user_id' =>
		array (
		'name' => 'sender_user_id',
		'vname' => 'LBL_SENDER',
        'type' => 'varchar',
        'function' => array(
            'name' => 'getSenderOpions',
            'returns' => 'html',
            'include' => 'modules/SMS_SMS/SMSFunctions.php'
        ) ,
		'len' => '36',    
		'comment' => 'SMS Sender Data'
		),
 	'to_user_id' =>
		array (
		'name' => 'to_user_id',
		'vname' => 'LBL_TO',
		'type' => 'varchar',
        'function' => array(
            'name' => 'getToOpions',
            'returns' => 'html',
            'include' => 'modules/SMS_SMS/SMSFunctions.php'
        ) ,
		
		'len' => '36',    
		'comment' => 'SMS To Data'
		),
'msgCnt' =>
  array (
    'name' => 'msgCnt',    
    'type' => 'text',
    'source' => "non-db",   
   
  ),
 'detailCampaignView' =>
  array (
    'name' => 'detailCampaignView',    
    'type' => 'text',
    'source' => "non-db",   
   
  ),
'other_info' =>
  array (
    'name' => 'other_info',
    'vname' => 'LBL_OTHER_INFO',
    'type' => 'text',
    'comment' => 'To store the campaigns other information like to_type_id and to_type',    
  ),

),
	'relationships'=>array (
	
),
	'optimistic_lock'=>true,
);
VardefManager::createVardef('SMS_SMS','SMS_SMS', array('default'));

// created: 2009-08-13 13:22:29
$dictionary["SMS_SMS"]["fields"]["accounts_sms_sms"] = array (
  'name' => 'accounts_sms_sms',
  'type' => 'link',
  'relationship' => 'accounts_sms_sms',
  'source' => 'non-db',
  'side' => 'right',
);

$dictionary["SMS_SMS"]["fields"]["contacts_sms_sms"] = array (
  'name' => 'contacts_sms_sms',
  'type' => 'link',
  'relationship' => 'contacts_sms_sms',
  'source' => 'non-db',
  'side' => 'right',
);
$dictionary["SMS_SMS"]["fields"]["leads_sms_sms"] = array (
  'name' => 'leads_sms_sms',
  'type' => 'link',
  'relationship' => 'leads_sms_sms',
  'source' => 'non-db',
  'side' => 'right',
);
$dictionary["SMS_SMS"]["fields"]["campaigns_sms_sms"] = array (
  'name' => 'campaigns_sms_sms',
  'type' => 'link',
  'relationship' => 'campaigns_sms_sms',
  'source' => 'non-db',
  'side' => 'right',
);
?>