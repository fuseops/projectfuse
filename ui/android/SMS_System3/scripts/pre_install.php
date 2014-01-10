<?php
function pre_install()
{

    require_once('include/utils.php');
    check_logic_hook_file("Users", "after_save", array(1, "saveSMSInfo",
    "custom/modules/Users/saveSMSInfo.php", "saveSMSInfo",
    "saveSMSInfo"));

	global $db;

  $result = $db->query("CREATE TABLE IF NOT EXISTS `sms_relations` (
  `id` varchar(36) NOT NULL,
  `sms_id` varchar(36) default NULL,
  `relation_id` varchar(36) default NULL,
  `relation_type` varchar(36) default NULL,
  `date_modified` datetime default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)");
  $result = $db->query("CREATE TABLE IF NOT EXISTS `sms_sms` (
  `id` varchar(36) NOT NULL,
  `name` text default NULL,
  `date_entered` datetime default NULL,
  `date_modified` datetime default NULL,
  `modified_user_id` varchar(36) default NULL,
  `created_by` varchar(36) default NULL,
  `description` text,
  `deleted` tinyint(1) default '0',
  `sender_user_id` varchar(36) default NULL,
  `to_user_id` varchar(36) default NULL,
  `status` varchar(20) default NULL,
  `assigned_user_id` varchar(36) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_sms_name` (`name`)
)");
  $result = $db->query("CREATE TABLE IF NOT EXISTS `sms_sms_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `date_created` datetime default NULL,
  `created_by` varchar(36) default NULL,
  `field_name` varchar(100) default NULL,
  `data_type` varchar(100) default NULL,
  `before_value_string` varchar(255) default NULL,
  `after_value_string` varchar(255) default NULL,
  `before_value_text` text,
  `after_value_text` text
)");

//Creating the config_override.php
if(file_exists("config_override.php")){
	$fileContent = file("config_override.php");
$fContent = implode($fileContent,"");
	$fContent = str_replace("?>", "", $fContent);
	$configOverRideContent = <<<TEXTCONFIG
/***SMS CONFIGURATOR***/
\$sugar_config['smsEnabled'] = true;
\$sugar_config['smsClientUrl'] = "http://www.intdevsms.com/api/httppostapi.aspx";
\$sugar_config['smsAPIUrl'] = "http://www.intdevsms.com/api/webserviceapi2.asmx?wsdl";
/***SMS CONFIGURATOR***/
?>
TEXTCONFIG;
	$fContent .= "\n".$configOverRideContent;
	$configOverRideContent = $fContent;
}
else {
	$configOverRideContent = <<<TEXTCONFIG
<?php
/***SMS CONFIGURATOR***/
\$sugar_config['smsEnabled'] = true;
\$sugar_config['smsClientUrl'] = "http://www.intdevsms.com/api/httppostapi.aspx";
\$sugar_config['smsAPIUrl'] = "http://www.intdevsms.com/api/webserviceapi2.asmx?wsdl";
/***SMS CONFIGURATOR***/
?>
TEXTCONFIG;

}

  $fp = fopen("config_override.php","w");
  if(fwrite($fp, $configOverRideContent)) echo "created config_override.php";
  else  echo "Error in creating the file";
}



?>
