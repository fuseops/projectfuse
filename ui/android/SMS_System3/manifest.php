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

	$manifest = array (
		 'acceptable_sugar_versions' => 
		  array (
	     	'5.5.*',
		  ),
		  'acceptable_sugar_flavors' =>
		  array(
		  	'CE', 'PRO','ENT'
		  ),
		  'readme'=>'',
		  'key'=>'SMSSystem',
		  'author' => 'Jeevan',
		  'description' => 'SMS System Support for Accounts, Contacts, Leads & Campaigns',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'SMS System',
		  'published_date' => '2010-03-15',
		  'type' => 'module',
		  'version' => '3.0',
		  'remove_tables' => 'prompt',
		  );
$installdefs = array (
  'id' => 'SMS',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'SMS_SMS',
      'class' => 'SMS_SMS',
      'path' => 'modules/SMS_SMS/SMS_SMS.php',
      'tab' => false,
    ),
  ),
 'layoutdefs'=> array(
	'0' => array(
		'from'=> '<basepath>/layoutdefs/contacts_layout_defs.php', 
		'to_module'=> 'Contacts',
		),
	'1' => array(
		'from'=> '<basepath>/layoutdefs/accounts_layout_defs.php', 
		'to_module'=> 'Accounts',
		),
	'2' => array(
		'from'=> '<basepath>/layoutdefs/leads_layout_defs.php', 
		'to_module'=> 'Leads',
		),
	'3' => array(
		'from'=> '<basepath>/layoutdefs/campaigns_layout_defs.php', 
		'to_module'=> 'Campaigns',
		),

  ),
  'vardefs'=> array(
	'0' => array(
		'from'=> '<basepath>/vardefs/contacts_vardefs.php', 
		'to_module'=> 'Contacts',
		),
	'1' => array(
		'from'=> '<basepath>/vardefs/accounts_vardefs.php', 
		'to_module'=> 'Accounts',
		),
	'2' => array(
		'from'=> '<basepath>/vardefs/leads_vardefs.php', 
		'to_module'=> 'Leads',
		),
	'3' => array(
		'from'=> '<basepath>/vardefs/campaigns_vardefs.php', 
		'to_module'=> 'Campaigns',
		),
	),
  'relationships' => 
  array (	
	'0' => array (
	  'module'=> 'Campaigns',
          'meta_data'=>'<basepath>/relationships/campaigns_sms_smsMetaData.php',
	  'module_vardefs'=>'<basepath>/vardefs/campaigns_vardefs.php',
          'module_layoutdefs'=>'<basepath>/layoutdefs/campaigns_layout_defs.php'
        ),
	'1' => array (
	  'module'=> 'Accounts',
          'meta_data'=>'<basepath>/relationships/accounts_sms_smsMetaData.php',
	  'module_vardefs'=>'<basepath>/vardefs/accounts_vardefs.php',
          'module_layoutdefs'=>'<basepath>/layoutdefs/accounts_layout_defs.php'
        ),
	'2' => array (
	  'module'=> 'Contacts',
          'meta_data'=>'<basepath>/relationships/contacts_sms_smsMetaData.php',
	  'module_vardefs'=>'<basepath>/vardefs/contacts_vardefs.php',
          'module_layoutdefs'=>'<basepath>/layoutdefs/contacts_layout_defs.php'
        ),
	'3' => array (
	  'module'=> 'Leads',
          'meta_data'=>'<basepath>/relationships/leads_sms_smsMetaData.php',
	  'module_vardefs'=>'<basepath>/vardefs/leads_vardefs.php',
          'module_layoutdefs'=>'<basepath>/layoutdefs/leads_layout_defs.php'
        ),

  ),
  'image_dir' => '<basepath>/icons',
  
 'logic_hooks' => array(
        // Users
        array(
            'module' => 'Users',
            'hook' => 'after_save',
            'order' => '1',
            'description' => 'saveSMSInfo',
            'file' => 'custom/modules/Users/saveSMSInfo.php',
            'class' => 'saveSMSInfo',
            'function' => 'saveSMSInfo',
        ),	
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),    
  ),
'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/SMS_SMS',
      'to' => 'modules/SMS_SMS',
    ),
   1 => 
	array ('from' => '<basepath>/SugarModules/SugarWidgets',
	      'to' => 'include/generic/SugarWidgets',
	),
   2 => 
	array('from'=> '<basepath>/SugarModules/custom/modules/Users/saveSMSInfo.php',
	     'to'=> 'custom/modules/Users/saveSMSInfo.php'
	),
   3 => 
	array('from'=> '<basepath>/SugarModules/modules/Users/EditView.php',
	  'to'=> 'modules/Users/EditView.php'
	),
   4 => 
	array('from'=> '<basepath>/SugarModules/modules/Users/EditView.tpl',
	  'to'=> 'modules/Users/EditView.tpl'
	),
   5 => 
	array('from'=> '<basepath>/SugarModules/modules/Users/DetailView.php',
	  'to'=> 'modules/Users/DetailView.php'
	),
   6 => 
	array('from'=> '<basepath>/SugarModules/modules/Users/DetailView.html',
	  'to'=> 'modules/Users/DetailView.html'
	),
   7 => 
	array('from'=> '<basepath>/SugarModules/modules/Users/sms.js',
	  'to'=> 'modules/Users/sms.js'
	),
  8 => 
	array('from'=> '<basepath>/lib',
	  'to'=> 'lib'
	),
  9 => 
	array('from'=> '<basepath>/SugarModules/modules/Campaigns/SendSMS.html',
	  'to'=> 'modules/Campaigns/SendSMS.html'
	),
  10 => 
	array('from'=> '<basepath>/SugarModules/modules/Campaigns/SendSMS.php',
	  'to'=> 'modules/Campaigns/SendSMS.php'
	),
  11 => 
	array('from'=> '<basepath>/SugarModules/custom/modules/Campaigns',
	  'to'=> 'custom/modules/Campaigns'
	), 
  ),
);
